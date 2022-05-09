<?php

namespace App\Modules\Distribution\Facades\Integrations;

use JsonMapper_Exception;
use JiraRestApi\Issue\Issue;
use JiraRestApi\JiraException;
use JiraRestApi\Issue\IssueField;
use JiraRestApi\Issue\IssueService;
use JiraRestApi\Configuration\ArrayConfiguration;

class JIRA
{
    private $jiraConfig;

    public function __construct()
    {
        $this->jiraConfig = new ArrayConfiguration(
            [

                'jiraHost'    => config('distribution.jira.host'),
                'jiraUser'    => config('distribution.jira.user'),
                'jiraPassword'=> config('distribution.jira.password'),

            ]
        );
    }

    /**
     * @throws JsonMapper_Exception
     * @throws JiraException
     */
    public function createIssue($projectId, $taskName, $taskDescription, $assigneeJiraID = null): Issue
    {
        $issueService = new IssueService($this->jiraConfig);

        $issueField = new IssueField();

        $issueField->setProjectKey($projectId)
            ->setSummary($taskName)
            ->setIssueType("Task")
            ->setDescription($taskDescription);

        if ($assigneeJiraID) {
            $issueField->setAssigneeAccountId($assigneeJiraID);
        }

        return $issueService->create($issueField);
    }
}
