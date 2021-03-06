<?php
namespace Vidal\DrugBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/** @ORM\Entity(repositoryClass="CompanyRepository") @ORM\Table(name="company") */
class Company
{
	/** @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue */
	protected $CompanyID;

	/** @ORM\Column(length=255) */
	protected $LocalName;

	/** @ORM\Column(length=255, nullable=true) */
	protected $GDDBName;

	/** @ORM\Column(length=30, nullable=true) */
	protected $Property;

	/**
	 * @ORM\ManyToOne(targetEntity="Country", inversedBy="companies")
	 * @ORM\JoinColumn(name="CountryCode", referencedColumnName="CountryCode")
	 */
	protected $CountryCode;

	/** @ORM\Column(length=10, nullable=true) */
	protected $CountryEditionCode = 'RUS';

	/** @ORM\OneToMany(targetEntity="ProductCompany", mappedBy="CompanyID") */
	protected $productCompany;

	/** @ORM\Column(type="integer", nullable=true) */
	protected $countProducts;

	/**
	 * @ORM\ManyToOne(targetEntity="CompanyGroup", inversedBy="companies")
	 * @ORM\JoinColumn(name="CompanyGroupID", referencedColumnName="CompanyGroupID")
	 */
	protected $CompanyGroupID;

	public function __construct()
	{
		$this->productCompanies = new ArrayCollection();
	}

	public function __toString()
	{
		$name = $this->CompanyID . ' - ' . $this->LocalName;

		if (!empty($this->Property)) {
			$name .= ', ' . $this->Property;
		}

		if ($country = $this->CountryCode) {
			$name .= ' [' . $country->getCountryCode() . ']';
		}

		return $name;
	}

	public function getId()
	{
		return $this->CompanyID;
	}

	/**
	 * @param mixed $CompanyID
	 */
	public function setCompanyID($CompanyID)
	{
		$this->CompanyID = $CompanyID;
	}

	/**
	 * @return mixed
	 */
	public function getCompanyID()
	{
		return $this->CompanyID;
	}

	/**
	 * @param mixed $CountryCode
	 */
	public function setCountryCode($CountryCode)
	{
		$this->CountryCode = $CountryCode;
	}

	/**
	 * @return mixed
	 */
	public function getCountryCode()
	{
		return $this->CountryCode;
	}

	/**
	 * @param mixed $CountryEditionCode
	 */
	public function setCountryEditionCode($CountryEditionCode)
	{
		$this->CountryEditionCode = $CountryEditionCode;
	}

	/**
	 * @return mixed
	 */
	public function getCountryEditionCode()
	{
		return $this->CountryEditionCode;
	}

	/**
	 * @param mixed $GDDBName
	 */
	public function setGDDBName($GDDBName)
	{
		$this->GDDBName = $GDDBName;
	}

	/**
	 * @return mixed
	 */
	public function getGDDBName()
	{
		return $this->GDDBName;
	}

	/**
	 * @param mixed $LocalName
	 */
	public function setLocalName($LocalName)
	{
		$this->LocalName = $LocalName;
	}

	/**
	 * @return mixed
	 */
	public function getLocalName()
	{
		return $this->LocalName;
	}

	/**
	 * @param mixed $Property
	 */
	public function setProperty($Property)
	{
		$this->Property = $Property;
	}

	/**
	 * @return mixed
	 */
	public function getProperty()
	{
		return $this->Property;
	}

	/**
	 * @param mixed $productCompany
	 */
	public function setProductCompany(ArrayCollection $productCompany)
	{
		$this->productCompany = $productCompany;
	}

	/**
	 * @return mixed
	 */
	public function getProductCompany()
	{
		return $this->productCompany;
	}

	/**
	 * @param mixed $countProducts
	 */
	public function setCountProducts($countProducts)
	{
		$this->countProducts = $countProducts;
	}

	/**
	 * @return mixed
	 */
	public function getCountProducts()
	{
		return $this->countProducts;
	}

	/**
	 * @param \Doctrine\Common\Collections\ArrayCollection $productCompanies
	 */
	public function setProductCompanies($productCompanies)
	{
		$this->productCompanies = $productCompanies;
	}

	/**
	 * @return \Doctrine\Common\Collections\ArrayCollection
	 */
	public function getProductCompanies()
	{
		return $this->productCompanies;
	}

	/**
	 * @param mixed $CompanyGroupID
	 */
	public function setCompanyGroupID($CompanyGroupID)
	{
		$this->CompanyGroupID = $CompanyGroupID;
	}

	/**
	 * @return mixed
	 */
	public function getCompanyGroupID()
	{
		return $this->CompanyGroupID;
	}
}