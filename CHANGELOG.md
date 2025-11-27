
# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).


## [6.0.1] 2024-11-27
### Changed
- Some changes in the UI.


## [5.1.2] 2024-07-30
### Fixed
- Only show active users in bulk schedule.


## [5.1.1] 2024-07-06
### Added
- Add Bulk shift creation from WFM Integration.


## [5.0.2] - 2024-03-23
### Added
- Add log when failed to assign task for Zendesk


## [5.0.1] - 2023-10-30
### Removed
- All in active team members in calendar view are removed.


## [5.0.5] - 2023-05-01
### Fixed
- Daylight saving timing issue in member schedules.


## [5.0.4] - 2023-04-07
### Changed
- On deleting a shift the zendesk tasks will be unassigned.
- On deleting a shift the daily tasks will be removed.


## [5.0.3] - 2023-04-03
### Added
- Add Force Scheduling process
- Add delete schedule (when schedule deleted all task related to this schedule will be deleted from JIRA)
- Add Schedule swapping between two team members (when schedule swapped all task related to the old member will be assigned to the new member in JIRA)


## [5.0.2] - 2023-03-21
### Added
- Add email in team member data 


## [5.0.1] - 2023-02-18
### Added
- Add integration with the HRMS when create shift / schedule
- Add integration with the HRMS when edit shift / schedule
- Add integration with the HRMS when delete shift / schedule


## [4.0.3] - 2022-08-23
### Added
- Add logs viewer for tracing


## [4.0.2] - 2022-08-23
### Added
- Validation for the shift period to be from 5 hours min to 10 hours max.


## [4.0.1] - 2022-08-22
### Fixed
- Crash of division by zero in main dashboard, when a new teamleader register for the first time.


## [3.0.8] - 2022-07-19
### Added
- Role and permissions for the whole system.
- Flash messages on all actions in the system.


## [3.0.7] - 2022-07-04
### Fixed
- pushing the same slot in the same day to change its time


## [3.0.6] - 2022-07-03
### Added
- Update any schedule slot in the shifts calendar
- Add validation for updating,deleting and adding slots.
- Add Toastr notification for the crud actions.


## [3.0.5] - 2022-06-28
### Fixed
- issue in the team member stats


## [3.0.4] - 2022-06-23
### Added
- Add stats page for every team member


## [3.0.3] - 2022-06-21
### Added
- Add zendesk performance graphs for the main dashboard


## [3.0.2] - 2022-06-20
### Added
- Graphs for the main dashboard

### Changed
- Stats cards 


## [3.0.1] - 2022-06-18
### Changed
- Add balance to zendesk task distribution algorithms

## [2.0.0] - 2022-06-12
### Added
- Upgrade php version from 7 to 8


## [1.0.0] - 2022-03-25
### Added
- Initiate Application
