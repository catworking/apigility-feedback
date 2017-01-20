<?php
namespace ApigilityFeedback\V1\Rest\Feedback;

use ApigilityBlog\DoctrineEntity\Article;
use ApigilityBlog\V1\Rest\Article\ArticleEntity;
use ApigilityCatworkFoundation\Base\ApigilityObjectStorageAwareEntity;
use ApigilityUser\DoctrineEntity\User;
use ApigilityUser\V1\Rest\User\UserEntity;

class FeedbackEntity extends ApigilityObjectStorageAwareEntity
{
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

    public function getArticle()
    {
        if ($this->article instanceof Article) return $this->hydrator->extract(new ArticleEntity($this->article, $this->serviceManager));
        else return $this->article;
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

    public function getUser()
    {
        if ($this->user instanceof User) return $this->hydrator->extract(new UserEntity($this->user, $this->serviceManager));
        else return $this->user;
    }

    public function setCreateTime(\DateTime $create_time)
    {
        $this->create_time = $create_time;
        return $this;
    }

    public function getCreateTime()
    {
        if ($this->create_time instanceof \DateTime) return $this->create_time->getTimestamp();
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
