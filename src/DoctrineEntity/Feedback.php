<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2017/1/5
 * Time: 14:45:17
 */
namespace ApigilityFeedback\DoctrineEntity;

use ApigilityBlog\DoctrineEntity\Article;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\ManyToOne;
use ApigilityUser\DoctrineEntity\User;

/**
 * Class Feedback
 * @package ApigilityFeedback\DoctrineEntity
 * @Entity @Table(name="apigilityfeedback_feedback")
 */
class Feedback
{
    const STATUS_WAIT_TO_RESOLVE = 1; // 待解决
    const STATUS_RESOLVED = 2;        // 已解决

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * 反馈类型
     *
     * @Column(type="string", length=50, nullable=true)
     */
    protected $type;

    /**
     * 关联的文章
     *
     * @ManyToOne(targetEntity="ApigilityBlog\DoctrineEntity\Article")
     * @JoinColumn(name="article_id", referencedColumnName="id")
     */
    protected $article;

    /**
     * 捆绑对象类型
     *
     * @Column(type="string", length=50, nullable=true)
     */
    protected $attached_object_type;

    /**
     * 捆绑对象标识
     *
     * @Column(type="string", length=50, nullable=true)
     */
    protected $attached_object_id;

    /**
     * 反馈者，ApigilityUser组件的User对象
     *
     * @ManyToOne(targetEntity="ApigilityUser\DoctrineEntity\User")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * 创建时间
     *
     * @Column(type="datetime", nullable=false)
     */
    protected $create_time;

    /**
     * 处理状态
     *
     * @Column(type="smallint", nullable=false)
     */
    protected $status;

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setArticle($article)
    {
        $this->article = $article;
        return $this;
    }

    /**
     * @return Article
     */
    public function getArticle()
    {
        return $this->article;
    }

    public function setAttachedObjectType($attached_object_type)
    {
        $this->attached_object_type = $attached_object_type;
        return $this;
    }

    public function getAttachedObjectType()
    {
        return $this->attached_object_type;
    }

    public function setAttachedObjectId($attached_object_id)
    {
        $this->attached_object_id = $attached_object_id;
        return $this;
    }

    public function getAttachedObjectId()
    {
        return $this->attached_object_id;
    }

    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    public function setCreateTime(\DateTime $create_time)
    {
        $this->create_time = $create_time;
        return $this;
    }

    public function getCreateTime()
    {
        return $this->create_time;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }
}