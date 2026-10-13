<?php

namespace TechNovz\PMT;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
use TechNovz\PMT\Admin\Settings;
use TechNovz\PMT\Shortcodes\ProjectShortcode;
use TechNovz\PMT\PostTypes\ProjectPostType;
use TechNovz\PMT\Rest\ProjectRestController;
use TechNovz\PMT\Taxonomies\ProjectCategory;
use TechNovz\PMT\Taxonomies\ProjectTechnology;
use TechNovz\PMT\PostTypes\ProjectFields;
use TechNovz\PMT\Database\ProjectViews;

class Plugin {

    public function init() {

        if ( is_admin() ) {
            ( new Settings() )->init();
        }
        ( new ProjectPostType() )->init();
        ( new ProjectShortcode() )->init();
        ( new ProjectRestController() )->init();
        ( new ProjectCategory() )->init();
        ( new ProjectTechnology() )->init();
        ( new ProjectFields() )->init();
        ( new ProjectViews() )->init();
    }
}
