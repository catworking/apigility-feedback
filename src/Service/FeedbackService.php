<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2017/1/5
 * Time: 14:45:48
 */
namespace ApigilityFeedback\Service;

use Zend\ServiceManager\ServiceManager;
use Zend\Hydrator\ClassMethods as ClassMethodsHydrator;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrineToolPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrinePaginatorAdapter;
use ApigilityFeedback\DoctrineEntity;
use Doctrine\ORM\Query\Expr;

class FeedbackService
{
    protected $classMethodsHydrator;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var \ApigilityBlog\Service\ArticleService
     */
    protected $articleService;

    /**
     * @var \ApigilityBlog\Service\MediaService
     */
    protected $mediaService;

    public function __construct(ServiceManager $services)
    {
        $this->classMethodsHydrator = new ClassMethodsHydrator();
        $this->em = $services->get('Doctrine\ORM\EntityManager');
        $this->articleService = $services->get('ApigilityBlog\Service\ArticleService');
        $this->mediaService = $services->get('ApigilityBlog\Service\MediaService');
    }

    /**
     * 创建一个反馈
     *
     * @param $data
     * @param $user
     * @return DoctrineEntity\Feedback
     * @throws \Exception
     */
    public function createFeedback($data, $user)
    {
        $feedback = new DoctrineEntity\Feedback();

        if (isset($data->article)) {
            $medias = [];
            if (isset($data->article['medias'])) {
                foreach ($data->article['medias'] as $media) {
                    $medias[] = $this->mediaService->createMedia((object)[
                        'uri' => $media['uri'],
                        'type' => $media['type']
                    ], $user);
                }
            }

            $article = null;
            if (isset($data->article['content'])) {
                $article = $this->articleService->createArticle((object)[
                    'content'=>$data->article['content']
                ], $user, $medias);
            } else {
                throw new \Exception('请输入反馈内容', 500);
            }

            $feedback->setArticle($article);
        }

        $feedback->setUser($user);

        if (isset($data->type)) $feedback->setType($data->type);
        if (isset($data->attached_object_type)) $feedback->setAttachedObjectType($data->attached_object_type);
        if (isset($data->attached_object_id)) $feedback->setAttachedObjectId($data->attached_object_id);
        $feedback->setCreateTime(new \DateTime());
        $feedback->setStatus(DoctrineEntity\Feedback::STATUS_WAIT_TO_RESOLVE);

        $this->em->persist($feedback);
        $this->em->flush();

        return $feedback;
    }

    /**
     * 获取一个反馈
     *
     * @param $feedback_id
     * @return DoctrineEntity\Feedback
     * @throws \Exception
     */
    public function getFeedback($feedback_id)
    {
        $feedback = $this->em->find('ApigilityFeedback\DoctrineEntity\Feedback', $feedback_id);
        if (empty($feedback)) throw new \Exception('反馈不存在', 404);
        else return $feedback;
    }

    /**
     * 获取反馈列表
     *
     * @param $params
     * @return DoctrinePaginatorAdapter
     */
    public function getFeedbacks($params)
    {
        $qb = new QueryBuilder($this->em);
        $qb->select('f')->from('ApigilityFeedback\DoctrineEntity\Feedback', 'f')->orderBy(new Expr\OrderBy('f.id', 'DESC'));;

        $where = '';

        if (isset($params->type)) {
            if (!empty($where)) $where .= ' AND ';
            $where .= 'f.type = :type';
        }

        if (isset($params->user_id)) {
            $qb->innerJoin('f.user', 'user');
            if (!empty($where)) $where .= ' AND ';
            $where .= 'user.id = :user_id';
        }

        if (isset($params->status)) {
            if (!empty($where)) $where .= ' AND ';
            $where .= 'f.status = :status';
        }

        if (!empty($where)) {
            $qb->where($where);
            if (isset($params->type)) $qb->setParameter('type', $params->type);
            if (isset($params->user_id)) $qb->setParameter('user_id', $params->user_id);
            if (isset($params->status)) $qb->setParameter('status', $params->status);
        }

        $doctrine_paginator = new DoctrineToolPaginator($qb->getQuery());
        return new DoctrinePaginatorAdapter($doctrine_paginator);
    }

    /**
     * 修改一个反馈
     *
     * @param $feedback_id
     * @param $data
     * @return DoctrineEntity\Feedback
     * @throws \Exception
     */
    public function updateFeedback($feedback_id, $data)
    {
        $feedback = $this->getFeedback($feedback_id);

        if (isset($data->type)) $feedback->setType($data->type);
        if (isset($data->attached_object_type)) $feedback->setAttachedObjectType($data->attached_object_type);
        if (isset($data->attached_object_id)) $feedback->setAttachedObjectId($data->attached_object_id);

        if (isset($data->status)) {
            switch ($data->status) {
                case DoctrineEntity\Feedback::STATUS_WAIT_TO_RESOLVE:
                    $feedback->setStatus(DoctrineEntity\Feedback::STATUS_WAIT_TO_RESOLVE);
                    break;

                case DoctrineEntity\Feedback::STATUS_RESOLVED:
                    $feedback->setStatus(DoctrineEntity\Feedback::STATUS_RESOLVED);
                    break;

                default:
                    throw new \Exception('未知的状态：'.$data->status, 500);
            }
        }

        $this->em->flush();

        return $feedback;
    }

    /**
     * 删除一个反馈
     *
     * @param $feedback_id
     * @return bool
     * @throws \Exception
     */
    public function deleteFeedback($feedback_id)
    {
        $feedback = $this->getFeedback($feedback_id);

        $this->em->remove($feedback);
        $this->em->flush();

        return true;
    }
}