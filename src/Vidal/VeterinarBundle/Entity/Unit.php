<?php
namespace Vidal\VeterinarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/** @ORM\Entity @ORM\Table(name="unit") */
class Unit
{
	/** @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue */
	protected $UnitID;

	/** @ORM\Column(length=40) */
	protected $RusName;

	/** @ORM\Column(length=40, nullable=true) */
	protected $EngName;

	/** @ORM\OneToMany(targetEntity="Package", mappedBy="ItemQuantityUnitID") */
	protected $packages;

	/** @ORM\OneToMany(targetEntity="ItemActiveIng", mappedBy="ItemID") */
	protected $itemActiveIngs;

	public function __construct()
	{
		$this->packages       = new ArrayCollection();
		$this->itemActiveIngs = new ArrayCollection();
	}

	public function __string()
	{
		return $this->RusName;
	}

	/**
	 * @param mixed $EngName
	 */
	public function setEngName($EngName)
	{
		$this->EngName = $EngName;
	}

	/**
	 * @return mixed
	 */
	public function getEngName()
	{
		return $this->EngName;
	}

	/**
	 * @param mixed $RusName
	 */
	public function setRusName($RusName)
	{
		$this->RusName = $RusName;
	}

	/**
	 * @return mixed
	 */
	public function getRusName()
	{
		return $this->RusName;
	}

	/**
	 * @param mixed $UnitID
	 */
	public function setUnitID($UnitID)
	{
		$this->UnitID = $UnitID;
	}

	/**
	 * @return mixed
	 */
	public function getUnitID()
	{
		return $this->UnitID;
	}

	/**
	 * @param mixed $packages
	 */
	public function setPackages(ArrayCollection $packages)
	{
		$this->packages = $packages;
	}

	/**
	 * @return mixed
	 */
	public function getPackages()
	{
		return $this->packages;
	}

	/**
	 * @param mixed $itemActiveIngs
	 */
	public function setItemActiveIngs(ArrayCollection $itemActiveIngs)
	{
		$this->itemActiveIngs = $itemActiveIngs;
	}

	/**
	 * @return mixed
	 */
	public function getItemActiveIngs()
	{
		return $this->itemActiveIngs;
	}
}