<?php
namespace ApigilityFeedback\V1\Rest\Feedback;

use ApigilityCatworkFoundation\Base\ApigilityResource;
use ApigilityFeedback\Service\FeedbackService;
use ApigilityUser\Service\UserService;
use Zend\ServiceManager\ServiceManager;
use ZF\ApiProblem\ApiProblem;

class FeedbackResource extends ApigilityResource
{
    /**
     * @var FeedbackService
     */
    protected $feedbackService;

    /**
     * @var UserService
     */
    protected $userService;

    public function __construct(ServiceManager $services)
    {
        parent::__construct($services);
        $this->feedbackService = $services->get('ApigilityFeedback\Service\FeedbackService');
        $this->userService = $services->get('ApigilityUser\Service\UserService');
    }

    public function fetch($id)
    {
        try {
            return new FeedbackEntity($this->feedbackService->getFeedback($id), $this->serviceManager);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    public function fetchAll($params = [])
    {
        try {
            return new FeedbackCollection($this->feedbackService->getFeedbacks($params), $this->serviceManager);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    public function create($data)
    {
        try {
            $auth_user = $this->userService->getAuthUser();
            return new FeedbackEntity($this->feedbackService->createFeedback($data, $auth_user), $this->serviceManager);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    public function patch($id, $data)
    {
        try {
            return new FeedbackEntity($this->feedbackService->updateFeedback($id, $data), $this->serviceManager);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            return $this->feedbackService->deleteFeedback($id);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }
}
