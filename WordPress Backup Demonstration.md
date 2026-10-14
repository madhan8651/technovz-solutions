WordPress Backup Configuration and Demonstration

**Project:** TechNovz Solutions — WordPress Website and Project Management Toolkit  
**Backup plugin:** UpdraftPlus  
**Backup date shown:** October 13, 2026, 12:50  
**Reported backup size:** 126.2 MB

## 1. Objective

Configure a WordPress backup plugin, create a backup of the website files and database, and record evidence that the backup operation completed.

## 2. Tool and Environment

- **Plugin:** UpdraftPlus WordPress Backup Plugin
- **Environment:** WordPress development website running through XAMPP, as applicable to the setup.

## 3. Procedure

1. Log in to the WordPress administration dashboard.
2. Open **Plugins → Add New Plugin**, search for **UpdraftPlus**, install it, and activate it.
3. Open **Settings → UpdraftPlus Backups** (menu wording may vary by plugin version).
4. On the **Backup / Restore** tab, select **Backup Now**.
5. Choose the options to include the database and website files, then confirm the backup.
6. Wait for the operation to finish. Review the backup entry under **Existing Backups** and open **View Log** to check the result.

## 4. Backup Details Observed

| Item | Observed value |
|---|---|
| Backup plugin | UpdraftPlus |
| Backup date shown in dashboard | October 13, 2026, 12:50 |
| Total size reported in log | 126.2 MB |
| Backup components listed | Database, Plugins, Themes, Uploads, Must-use plugins, and Other files |
| Remote storage evidence | Google Drive icon shown; log reports that the database archive upload completed |
| Final log status | “The backup succeeded and is now complete.” |
| Upload errors | Log reports no upload errors |

## 5. Screenshot Evidence


### Figure 1 — UpdraftPlus Backup / Restore screen

<img width="1673" height="435" alt="image" src="https://github.com/user-attachments/assets/c560fac4-bbd1-4175-8647-15df4723a5b6" />


### Figure 2 — Backup completion log

<img width="1917" height="862" alt="image" src="https://github.com/user-attachments/assets/fd428962-a605-4c6b-9d5a-de8f7ad9a148" />


## 6. Result

UpdraftPlus displayed a backup entry dated October 13, 2026, at 12:50. The log reported a total backup size of 126.2 MB and stated that the backup succeeded and was complete. The log also recorded successful upload of the database archive to Google Drive and no upload errors.

## 7. Conclusion

The backup creation demonstration was completed using UpdraftPlus. The dashboard entry and completion log provide evidence for the Module 8 backup requirement. Insert the actual screenshots before submitting this report.
