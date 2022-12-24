@block @block_moodletest_modulelist
Feature: Block customecourse_modules
  In order to list of activity modules in a course
  As a manager
  I can add customecourse_modules block in a course

  Scenario: Add moodletest_modulelist block in a course
    Given the following "courses" exist:
      | fullname | shortname | format |
      | Course 1 | C1        | topics |
    And the following "activities" exist:
      | activity   | name              | intro                     | course | Completion Status
      | assign     | Test assignment   | Test assignment summary   | C1     | 1
      | book       | Test book         | Test book summary         | C1     | 
      | page       | Test page         | Test page summary         | C1     | 1
      | scorm      | Test scorm        | Test scorm summary        | C1     |

    When I log in as "admin"
    And I am on "Course 1" course homepage with editing mode on
    And I add the "moodletest_modulelist" block
    And I should see all the course modules/activities list with link, id, module name, creation date, completion status
    And I should see completion status Completed(1 = completed) for activity assign.
    And I should see completion status Completed(1 = completed) for activity page.
    And When I clicks on list link, it should jump on course activity view page.
    