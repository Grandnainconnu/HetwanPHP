<?php

namespace Hetwan\Entity\Login;

use Doctrine\Common\Collections\ArrayCollection;


/**
 * @Entity
 * @Table(name="accounts")
 **/
class AccountEntity
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="string", unique=true)
     */
    private $username;

    /**
     * @Column(type="string")
     */
    private $password;

    /**
     * @Column(type="string", nullable=true, unique=true)
     */
    private $nickname;

    /**
     * @Column(type="string")
     */
    private $secretQuestion;

    /**
     * @Column(type="string")
     */
    private $secretAnswer;

    /**
     * @Column(type="integer", options={"default":"0"})
     */
    private $community;

    /**
     * @Column(type="integer", options={"default":"0"})
     */
    private $subscriptionTimeLeft;

    /**
     * @Column(type="datetime", nullable=true)
     */
    private $lastConnectionDate;

    /**
     * @Column(type="string", nullable=true)
     */
    private $lastConnectionIpAddress;

    /**
     * @Column(type="integer", options={"default":"0"})
     */
    private $gmLevel;

    /**
     * @Column(type="integer", options={"default":"5"})
     */
    private $maxPlayers;

    /**
     * @Column(type="boolean", options={"default":"0"})
     */
    private $isOnline;

    /**
     * @OneToOne(targetEntity="BannedAccountEntity")
     * @JoinColumn(name="isBanned", referencedColumnName="id")
     */
    private $isBanned;

    /**
     * @Column(type="boolean", options={"default":"0"})
     */
    private $muted;

    /**
     * @Column(type="boolean", options={"default":"0"})
     */
    private $friendConnectionNotification;

    /**
     * @Column(type="array", nullable=true)
     */
    private $friends;

    /**
     * @Column(type="array", nullable=true)
     */
    private $enemies;

    /**
     * @Column(type="array", nullable=true)
     */
    private $ignored;

    /**
     * @Column(type="array", nullable=true)
     */
    private $players;

    /**
     * @OneToMany(targetEntity="GiftEntity", mappedBy="accountId")
     */
    private $gifts;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->gifts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username.
     *
     * @param string $username
     *
     * @return AccountEntity
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password.
     *
     * @param string $password
     *
     * @return AccountEntity
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set nickname.
     *
     * @param string|null $nickname
     *
     * @return AccountEntity
     */
    public function setNickname($nickname = null)
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * Get nickname.
     *
     * @return string|null
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Set secretQuestion.
     *
     * @param string $secretQuestion
     *
     * @return AccountEntity
     */
    public function setSecretQuestion($secretQuestion)
    {
        $this->secretQuestion = $secretQuestion;

        return $this;
    }

    /**
     * Get secretQuestion.
     *
     * @return string
     */
    public function getSecretQuestion()
    {
        return $this->secretQuestion;
    }

    /**
     * Set secretAnswer.
     *
     * @param string $secretAnswer
     *
     * @return AccountEntity
     */
    public function setSecretAnswer($secretAnswer)
    {
        $this->secretAnswer = $secretAnswer;

        return $this;
    }

    /**
     * Get secretAnswer.
     *
     * @return string
     */
    public function getSecretAnswer()
    {
        return $this->secretAnswer;
    }

    /**
     * Set community.
     *
     * @param int $community
     *
     * @return AccountEntity
     */
    public function setCommunity($community)
    {
        $this->community = $community;

        return $this;
    }

    /**
     * Get community.
     *
     * @return int
     */
    public function getCommunity()
    {
        return $this->community;
    }

    /**
     * Set subscriptionTimeLeft.
     *
     * @param int $subscriptionTimeLeft
     *
     * @return AccountEntity
     */
    public function setSubscriptionTimeLeft($subscriptionTimeLeft)
    {
        $this->subscriptionTimeLeft = $subscriptionTimeLeft;

        return $this;
    }

    /**
     * Get subscriptionTimeLeft.
     *
     * @return int
     */
    public function getSubscriptionTimeLeft()
    {
        return $this->subscriptionTimeLeft;
    }

    /**
     * Set lastConnectionDate.
     *
     * @param \DateTime|null $lastConnectionDate
     *
     * @return AccountEntity
     */
    public function setLastConnectionDate($lastConnectionDate = null)
    {
        $this->lastConnectionDate = $lastConnectionDate;

        return $this;
    }

    /**
     * Get lastConnectionDate.
     *
     * @return \DateTime|null
     */
    public function getLastConnectionDate()
    {
        return $this->lastConnectionDate;
    }

    /**
     * Set lastConnectionIpAddress.
     *
     * @param string|null $lastConnectionIpAddress
     *
     * @return AccountEntity
     */
    public function setLastConnectionIpAddress($lastConnectionIpAddress = null)
    {
        $this->lastConnectionIpAddress = $lastConnectionIpAddress;

        return $this;
    }

    /**
     * Get lastConnectionIpAddress.
     *
     * @return string|null
     */
    public function getLastConnectionIpAddress()
    {
        return $this->lastConnectionIpAddress;
    }

    /**
     * Set gmLevel.
     *
     * @param int $gmLevel
     *
     * @return AccountEntity
     */
    public function setGmLevel($gmLevel)
    {
        $this->gmLevel = $gmLevel;

        return $this;
    }

    /**
     * Get gmLevel.
     *
     * @return int
     */
    public function getGmLevel()
    {
        return $this->gmLevel;
    }

    /**
     * Set maxPlayers.
     *
     * @param int $maxPlayers
     *
     * @return AccountEntity
     */
    public function setMaxPlayers($maxPlayers)
    {
        $this->maxPlayers = $maxPlayers;

        return $this;
    }

    /**
     * Get maxPlayers.
     *
     * @return int
     */
    public function getMaxPlayers()
    {
        return $this->maxPlayers;
    }

    /**
     * Set isOnline.
     *
     * @param bool $isOnline
     *
     * @return AccountEntity
     */
    public function setIsOnline($isOnline)
    {
        $this->isOnline = $isOnline;

        return $this;
    }

    /**
     * Get isOnline.
     *
     * @return bool
     */
    public function getIsOnline()
    {
        return $this->isOnline;
    }

    /**
     * Set muted.
     *
     * @param bool $muted
     *
     * @return AccountEntity
     */
    public function setMuted($muted)
    {
        $this->muted = $muted;

        return $this;
    }

    /**
     * Get muted.
     *
     * @return bool
     */
    public function getMuted()
    {
        return $this->muted;
    }

    /**
     * Set friendConnectionNotification.
     *
     * @param bool $friendConnectionNotification
     *
     * @return AccountEntity
     */
    public function setFriendConnectionNotification($friendConnectionNotification)
    {
        $this->friendConnectionNotification = $friendConnectionNotification;

        return $this;
    }

    /**
     * Get friendConnectionNotification.
     *
     * @return bool
     */
    public function getFriendConnectionNotification()
    {
        return $this->friendConnectionNotification;
    }

    /**
     * Set friends.
     *
     * @param array|null $friends
     *
     * @return AccountEntity
     */
    public function setFriends($friends = null)
    {
        $this->friends = $friends;

        return $this;
    }

    /**
     * Get friends.
     *
     * @return array|null
     */
    public function getFriends()
    {
        return $this->friends;
    }

    /**
     * Set enemies.
     *
     * @param array|null $enemies
     *
     * @return AccountEntity
     */
    public function setEnemies($enemies = null)
    {
        $this->enemies = $enemies;

        return $this;
    }

    /**
     * Get enemies.
     *
     * @return array|null
     */
    public function getEnemies()
    {
        return $this->enemies;
    }

    /**
     * Set ignored.
     *
     * @param array|null $ignored
     *
     * @return AccountEntity
     */
    public function setIgnored($ignored = null)
    {
        $this->ignored = $ignored;

        return $this;
    }

    /**
     * Get ignored.
     *
     * @return array|null
     */
    public function getIgnored()
    {
        return $this->ignored;
    }

    /**
     * Set players.
     *
     * @param array|null $players
     *
     * @return AccountEntity
     */
    public function setPlayers($players = null)
    {
        $this->players = $players;

        return $this;
    }

    /**
     * Get players.
     *
     * @return array|null
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * Set isBanned.
     *
     * @param \Hetwan\Entity\Login\BannedAccountEntity|null $isBanned
     *
     * @return AccountEntity
     */
    public function setIsBanned(\Hetwan\Entity\Login\BannedAccountEntity $isBanned = null)
    {
        $this->isBanned = $isBanned;

        return $this;
    }

    /**
     * Get isBanned.
     *
     * @return \Hetwan\Entity\Login\BannedAccountEntity|null
     */
    public function getIsBanned()
    {
        return $this->isBanned;
    }

    /**
     * Add gift.
     *
     * @param \Hetwan\Entity\Login\GiftEntity $gift
     *
     * @return AccountEntity
     */
    public function addGift(\Hetwan\Entity\Login\GiftEntity $gift)
    {
        $this->gifts[] = $gift;

        return $this;
    }

    /**
     * Remove gift.
     *
     * @param \Hetwan\Entity\Login\GiftEntity $gift
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeGift(\Hetwan\Entity\Login\GiftEntity $gift)
    {
        return $this->gifts->removeElement($gift);
    }

    /**
     * Get gifts.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGifts()
    {
        return $this->gifts;
    }
}
