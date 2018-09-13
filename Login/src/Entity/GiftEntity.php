<?php
namespace Hetwan\Entity;


/**
* @Entity
* @Table(name="gifts")
**/
class GiftEntity
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="AccountEntity", inversedBy="gifts")
     * @JoinColumn(name="accountId", referencedColumnName="id")
     */
    private $accountId;

    /**
     * @Column(name="itemDataId", type="integer", nullable=false)
     * @var int
     */
    private $itemDataId;

    /**
     * @Column(name="quantity", type="integer", options={"default":"1"}, nullable=false)
     * @var int
     */
    private $quantity;

    /**
     * @Column(name="serverId", type="integer")
     * @var int
     */
    private $serverId;

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
     * Set itemDataId.
     *
     * @param int $itemDataId
     *
     * @return GiftEntity
     */
    public function setItemDataId($itemDataId)
    {
        $this->itemDataId = $itemDataId;

        return $this;
    }

    /**
     * Get itemDataId.
     *
     * @return int
     */
    public function getItemDataId()
    {
        return $this->itemDataId;
    }

    /**
     * Set quantity.
     *
     * @param int $quantity
     *
     * @return GiftEntity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity.
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set serverId.
     *
     * @param int $serverId
     *
     * @return GiftEntity
     */
    public function setServerId($serverId)
    {
        $this->serverId = $serverId;

        return $this;
    }

    /**
     * Get serverId.
     *
     * @return int
     */
    public function getServerId()
    {
        return $this->serverId;
    }

    /**
     * Set accountId.
     *
     * @param \Hetwan\Entity\Login\AccountEntity|null $accountId
     *
     * @return GiftEntity
     */
    public function setAccountId(\Hetwan\Entity\Login\AccountEntity $accountId = null)
    {
        $this->accountId = $accountId;

        return $this;
    }

    /**
     * Get accountId.
     *
     * @return \Hetwan\Entity\Login\AccountEntity|null
     */
    public function getAccountId()
    {
        return $this->accountId;
    }
}
