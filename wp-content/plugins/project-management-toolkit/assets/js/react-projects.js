(function () {
    const { createElement: el, useEffect, useState } = wp.element;

    function ProjectCard({ project }) {
        return el(
            'article',
            { className: 'pmt-project-card' },

            project.image_url
                ? el('img', {
                    src: project.image_url,
                    alt: project.title,
                    loading: 'lazy'
                })
                : null,

            el(
                'div',
                { className: 'pmt-project-content' },

                el('h3', null, project.title),

                el(
                    'p',
                    { className: 'pmt-project-category' },
                    (project.category || []).join(', ')
                ),

                el('p', null, project.description),

                el(
                    'a',
                    {
                        href: project.project_url,
                        className: 'pmt-project-link'
                    },
                    'View Project'
                )
            )
        );
    }

    function ProjectListing() {
        const [projects, setProjects] = useState([]);
        const [page, setPage] = useState(1);
        const [totalPages, setTotalPages] = useState(1);
        const [loading, setLoading] = useState(true);
        const [loadingMore, setLoadingMore] = useState(false);
        const [error, setError] = useState('');

        // Load the first batch through the REST API.
        useEffect(() => {
            let cancelled = false;

            setLoading(true);
            setError('');

            fetch(
                pmtReactProjects.apiUrl + '?page=1&per_page=2'
            )
                .then(function (response) {
                    if (!response.ok) {
                        throw new Error('Unable to load projects.');
                    }

                    return response.json();
                })
                .then(function (result) {
                    if (cancelled) return;

                    setProjects(result.data || []);
                    setPage(1);
                    setTotalPages(
                        result.pagination
                            ? result.pagination.total_pages
                            : 1
                    );
                })
                .catch(function () {
                    if (!cancelled) {
                        setError('Could not load projects. Please refresh and try again.');
                    }
                })
                .finally(function () {
                    if (!cancelled) {
                        setLoading(false);
                    }
                });

            return function () {
                cancelled = true;
            };
        }, []);

        // Load the next batch through WordPress AJAX.
        function loadMoreProjects() {
            if (loadingMore || page >= totalPages) {
                return;
            }

            setLoadingMore(true);
            setError('');

            const formData = new URLSearchParams();

            formData.append('action', 'pmt_load_more_projects');
            formData.append('nonce', pmtReactProjects.nonce);
            formData.append('page', String(page + 1));

            fetch(pmtReactProjects.ajaxUrl, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
                },
                body: formData.toString()
            })
                .then(function (response) {
                    return response.json().then(function (data) {
                        if (!response.ok || !data.success) {
                            const message =
                                data.data && data.data.message
                                    ? data.data.message
                                    : 'Unable to load more projects.';

                            throw new Error(message);
                        }

                        return data;
                    });
                })
                .then(function (result) {
                    const newProjects = result.data.data || [];
                    const pagination = result.data.pagination || {};

                    setProjects(function (currentProjects) {
                        const existingIds = new Set(
    currentProjects.map(function (project) {
        return Number(project.id);
    })
);

const uniqueProjects = newProjects.filter(function (project) {
    const projectId = Number(project.id);

    if (!Number.isInteger(projectId) || projectId <= 0) {
        return false;
    }

    if (existingIds.has(projectId)) {
        return false;
    }

    existingIds.add(projectId);
    return true;
});

                        return currentProjects.concat(uniqueProjects);
                    });

                    setPage(pagination.current_page || page + 1);
                    setTotalPages(pagination.total_pages || totalPages);
                })
                .catch(function (error) {
                    setError(error.message || 'Could not load more projects.');
                })
                .finally(function () {
                    setLoadingMore(false);
                });
        }

        return el(
            'section',
            { className: 'pmt-react-listing' },

            el(
                'div',
                { className: 'pmt-project-grid' },
                projects.map(function (project) {
                    return el(ProjectCard, {
                        key: project.id,
                        project: project
                    });
                })
            ),

            loading
                ? el('p', null, 'Loading projects...')
                : null,

            error
                ? el('p', { role: 'alert' }, error)
                : null,

            !loading && !error && projects.length === 0
                ? el('p', null, 'No projects found.')
                : null,

            !loading && page < totalPages
                ? el(
                    'div',
                    { className: 'pmt-pagination' },
                    el(
                        'button',
                        {
                            type: 'button',
                            onClick: loadMoreProjects,
                            disabled: loadingMore
                        },
                        loadingMore ? 'Loading...' : 'Load More Projects'
                    )
                )
                : null
        );
    }

    function mount() {
        const root = document.getElementById('pmt-react-projects');

        if (!root || root.dataset.mounted) {
            return;
        }

        root.dataset.mounted = 'true';

        if (typeof wp.element.createRoot === 'function') {
            wp.element.createRoot(root).render(el(ProjectListing));
        } else {
            wp.element.render(el(ProjectListing), root);
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', mount);
    } else {
        mount();
    }
})();
