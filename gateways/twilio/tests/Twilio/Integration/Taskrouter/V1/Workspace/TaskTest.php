<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Tests\Integration\Taskrouter\V1\Workspace;

use Twilio\Exceptions\DeserializeException;
use Twilio\Exceptions\TwilioException;
use Twilio\Http\Response;
use Twilio\Tests\HolodeckTestCase;
use Twilio\Tests\Request;

class TaskTest extends HolodeckTestCase {
    public function testFetchRequest() {
        $this->holodeck->mock(new Response(500, ''));

        try {
            $this->twilio->taskrouter->v1->workspaces("WSXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX")
                                         ->tasks("WTXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX")->fetch();
        } catch (DeserializeException $e) {}
          catch (TwilioException $e) {}

        $this->assertRequest(new Request(
            'get',
            'https://taskrouter.twilio.com/v1/Workspaces/WSXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX/Tasks/WTXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX'
        ));
    }

    public function testFetchResponse() {
        $this->holodeck->mock(new Response(
            200,
            '
            {
                "account_sid": "ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "age": 25200,
                "assignment_status": "pending",
                "attributes": "{\\"body\\": \\"hello\\"}",
                "date_created": "2014-05-14T18:50:02Z",
                "date_updated": "2014-05-15T07:26:06Z",
                "priority": 0,
                "reason": "Test Reason",
                "sid": "WTaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "task_queue_sid": "WQaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "task_channel_sid": "TCaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "task_channel_unique_name": "task-channel",
                "timeout": 60,
                "url": "https://taskrouter.twilio.com/v1/Workspaces/WSaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Tasks/WTaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "workflow_sid": "WFaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "workspace_sid": "WSaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "workflow_friendly_name": "Test Workflow",
                "task_queue_friendly_name": "Test Queue",
                "addons": "{}",
                "links": {
                    "task_queue": "https://taskrouter.twilio.com/v1/Workspaces/WSaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/TaskQueues/WQaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                    "workflow": "https://taskrouter.twilio.com/v1/Workspaces/WSaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Workflows/WFaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                    "workspace": "https://taskrouter.twilio.com/v1/Workspaces/WSaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                    "reservations": "https://taskrouter.twilio.com/v1/Workspaces/WSaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Tasks/WTaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Reservations"
                }
            }
            '
        ));

        $actual = $this->twilio->taskrouter->v1->workspaces("WSXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX")
                                               ->tasks("WTXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX")->fetch();

        $this->assertNotNull($actual);
    }

    public function testUpdateRequest() {
        $this->holodeck->mock(new Response(500, ''));

        try {
            $this->twilio->taskrouter->v1->workspaces("WSXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX")
                                         ->tasks("WTXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX")->update();
        } catch (DeserializeException $e) {}
          catch (TwilioException $e) {}

        $this->assertRequest(new Request(
            'post',
            'https://taskrouter.twilio.com/v1/Workspaces/WSXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX/Tasks/WTXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX'
        ));
    }

    public function testUpdateResponse() {
        $this->holodeck->mock(new Response(
            200,
            '
            {
                "account_sid": "ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "age": 25200,
                "assignment_status": "pending",
                "attributes": "{\\"body\\": \\"hello\\"}",
                "date_created": "2014-05-14T18:50:02Z",
                "date_updated": "2014-05-15T07:26:06Z",
                "priority": 0,
                "reason": "Test Reason",
                "sid": "WTaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "task_queue_sid": "WQaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "task_channel_sid": "TCaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "task_channel_unique_name": "task-channel",
                "timeout": 60,
                "url": "https://taskrouter.twilio.com/v1/Workspaces/WSaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Tasks/WTaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "workflow_sid": "WFaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "workspace_sid": "WSaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "workflow_friendly_name": "Test Workflow",
                "task_queue_friendly_name": "Test Queue",
                "addons": "{}",
                "links": {
                    "task_queue": "https://taskrouter.twilio.com/v1/Workspaces/WSaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/TaskQueues/WQaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                    "workflow": "https://taskrouter.twilio.com/v1/Workspaces/WSaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Workflows/WFaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                    "workspace": "https://taskrouter.twilio.com/v1/Workspaces/WSaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                    "reservations": "https://taskrouter.twilio.com/v1/Workspaces/WSaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Tasks/WTaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Reservations"
                }
            }
            '
        ));

        $actual = $this->twilio->taskrouter->v1->workspaces("WSXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX")
                                               ->tasks("WTXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX")->update();

        $this->assertNotNull($actual);
    }

    public function testDeleteRequest() {
        $this->holodeck->mock(new Response(500, ''));

        try {
            $this->twilio->taskrouter->v1->workspaces("WSXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX")
                                         ->tasks("WTXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX")->delete();
        } catch (DeserializeException $e) {}
          catch (TwilioException $e) {}

        $this->assertRequest(new Request(
            'delete',
            'https://taskrouter.twilio.com/v1/Workspaces/WSXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX/Tasks/WTXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX'
        ));
    }

    public function testDeleteResponse() {
        $this->holodeck->mock(new Response(
            204,
            null
        ));

        $actual = $this->twilio->taskrouter->v1->workspaces("WSXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX")
                                               ->tasks("WTXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX")->delete();

        $this->assertTrue($actual);
    }

    public function testReadRequest() {
        $this->holodeck->mock(new Response(500, ''));

        try {
            $this->twilio->taskrouter->v1->workspaces("WSXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX")
                                         ->tasks->read();
        } catch (DeserializeException $e) {}
          catch (TwilioException $e) {}

        $this->assertRequest(new Request(
            'get',
            'https://taskrouter.twilio.com/v1/Workspaces/WSXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX/Tasks'
        ));
    }

    public function testReadFullResponse() {
        $this->holodeck->mock(new Response(
            200,
            '
            {
                "meta": {
                    "first_page_url": "https://taskrouter.twilio.com/v1/Workspaces/WSaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Tasks?TaskQueueSid=WQaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa&Priority=1&TaskQueueName=task_queue_name&WorkflowName=workflow_name&WorkflowSid=WFaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa&AssignmentStatus=pending%2Creserved&PageSize=50&Page=0",
                    "key": "tasks",
                    "next_page_url": null,
                    "page": 0,
                    "page_size": 50,
                    "previous_page_url": null,
                    "url": "https://taskrouter.twilio.com/v1/Workspaces/WSaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Tasks?TaskQueueSid=WQaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa&Priority=1&TaskQueueName=task_queue_name&WorkflowName=workflow_name&WorkflowSid=WFaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa&AssignmentStatus=pending%2Creserved&PageSize=50&Page=0"
                },
                "tasks": [
                    {
                        "account_sid": "ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                        "age": 25200,
                        "assignment_status": "pending",
                        "attributes": "{\\"body\\": \\"hello\\"}",
                        "date_created": "2014-05-14T14:26:54Z",
                        "date_updated": "2014-05-15T16:03:42Z",
                        "priority": 0,
                        "reason": "Test Reason",
                        "sid": "WTaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                        "task_queue_sid": "WQaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                        "task_channel_sid": "TCaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                        "task_channel_unique_name": "task-channel",
                        "timeout": 60,
                        "url": "https://taskrouter.twilio.com/v1/Workspaces/WSaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Tasks/WTaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                        "workflow_sid": "WFaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                        "workspace_sid": "WSaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                        "workflow_friendly_name": "Test Workflow",
                        "task_queue_friendly_name": "Test Queue",
                        "addons": "{}",
                        "links": {
                            "task_queue": "https://taskrouter.twilio.com/v1/Workspaces/WSaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/TaskQueues/WQaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                            "workflow": "https://taskrouter.twilio.com/v1/Workspaces/WSaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Workflows/WFaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                            "workspace": "https://taskrouter.twilio.com/v1/Workspaces/WSaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                            "reservations": "https://taskrouter.twilio.com/v1/Workspaces/WSaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Tasks/WTaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Reservations"
                        }
                    }
                ]
            }
            '
        ));

        $actual = $this->twilio->taskrouter->v1->workspaces("WSXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX")
                                               ->tasks->read();

        $this->assertGreaterThan(0, \count($actual));
    }

    public function testReadEmptyResponse() {
        $this->holodeck->mock(new Response(
            200,
            '
            {
                "meta": {
                    "first_page_url": "https://taskrouter.twilio.com/v1/Workspaces/WSaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Tasks?TaskQueueSid=WQaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa&Priority=1&TaskQueueName=task_queue_name&WorkflowName=workflow_name&WorkflowSid=WFaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa&AssignmentStatus=pending&PageSize=50&Page=0",
                    "key": "tasks",
                    "next_page_url": null,
                    "page": 0,
                    "page_size": 50,
                    "previous_page_url": null,
                    "url": "https://taskrouter.twilio.com/v1/Workspaces/WSaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Tasks?TaskQueueSid=WQaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa&Priority=1&TaskQueueName=task_queue_name&WorkflowName=workflow_name&WorkflowSid=WFaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa&AssignmentStatus=pending&PageSize=50&Page=0"
                },
                "tasks": []
            }
            '
        ));

        $actual = $this->twilio->taskrouter->v1->workspaces("WSXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX")
                                               ->tasks->read();

        $this->assertNotNull($actual);
    }

    public function testReadAssignmentStatusMultipleResponse() {
        $this->holodeck->mock(new Response(
            200,
            '
            {
                "meta": {
                    "first_page_url": "https://taskrouter.twilio.com/v1/Workspaces/WSaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Tasks?TaskQueueSid=WQaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa&Priority=1&TaskQueueName=task_queue_name&WorkflowName=workflow_name&WorkflowSid=WFaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa&AssignmentStatus=pending&PageSize=50&Page=0",
                    "key": "tasks",
                    "next_page_url": null,
                    "page": 0,
                    "page_size": 50,
                    "previous_page_url": null,
                    "url": "https://taskrouter.twilio.com/v1/Workspaces/WSaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Tasks?TaskQueueSid=WQaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa&Priority=1&TaskQueueName=task_queue_name&WorkflowName=workflow_name&WorkflowSid=WFaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa&AssignmentStatus=pending&PageSize=50&Page=0"
                },
                "tasks": []
            }
            '
        ));

        $actual = $this->twilio->taskrouter->v1->workspaces("WSXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX")
                                               ->tasks->read();

        $this->assertNotNull($actual);
    }

    public function testCreateRequest() {
        $this->holodeck->mock(new Response(500, ''));

        try {
            $this->twilio->taskrouter->v1->workspaces("WSXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX")
                                         ->tasks->create();
        } catch (DeserializeException $e) {}
          catch (TwilioException $e) {}

        $this->assertRequest(new Request(
            'post',
            'https://taskrouter.twilio.com/v1/Workspaces/WSXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX/Tasks'
        ));
    }

    public function testCreateResponse() {
        $this->holodeck->mock(new Response(
            201,
            '
            {
                "account_sid": "ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "age": 25200,
                "assignment_status": "pending",
                "attributes": "{\\"body\\": \\"attributes\\"}",
                "date_created": "2014-05-14T18:50:02Z",
                "date_updated": "2014-05-15T07:26:06Z",
                "priority": 1,
                "reason": "Test Reason",
                "sid": "WTaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "task_queue_sid": "WQaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "task_channel_sid": "TCaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "task_channel_unique_name": "unique",
                "timeout": 60,
                "url": "https://taskrouter.twilio.com/v1/Workspaces/WSaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Tasks/WTaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "workspace_sid": "WSaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "workflow_sid": "WFaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "workflow_friendly_name": "Example Workflow",
                "task_queue_friendly_name": "Example Task Queue",
                "addons": "{}",
                "links": {
                    "task_queue": "https://taskrouter.twilio.com/v1/Workspaces/WSaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/TaskQueues/WQaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                    "workflow": "https://taskrouter.twilio.com/v1/Workspaces/WSaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Workflows/WFaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                    "workspace": "https://taskrouter.twilio.com/v1/Workspaces/WSaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                    "reservations": "https://taskrouter.twilio.com/v1/Workspaces/WSaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Tasks/WTaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Reservations"
                }
            }
            '
        ));

        $actual = $this->twilio->taskrouter->v1->workspaces("WSXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX")
                                               ->tasks->create();

        $this->assertNotNull($actual);
    }
}