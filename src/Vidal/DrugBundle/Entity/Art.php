<?php

namespace Vidal\DrugBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/** @ORM\Entity(repositoryClass="ArtRepository") @ORM\Table(name="art") */
class Art extends BaseEntity
{
	/** @ORM\Column(length=255) */
	protected $title;

	/** @ORM\Column(type="text", nullable=true) */
	protected $announce;

	/** @ORM\Column(type="text", nullable=true) */
	protected $body;

	/**
	 * @ORM\Column(length=255, nullable=true)
	 * @Assert\Regex(
	 *     pattern="/[a-zA-Z\d\-\_\.]+/",
	 *     match=true,
	 *     message="Ссылка может состоять только из латинских букв, цифр, тире, точки и подчеркивания."
	 * )
	 */
	protected $link;

	/**
	 * @ORM\ManyToMany(targetEntity="Nozology", inversedBy="arts")
	 * @ORM\JoinTable(name="art_n",
	 *        joinColumns={@ORM\JoinColumn(name="art_id", referencedColumnName="id")},
	 *        inverseJoinColumns={@ORM\JoinColumn(name="NozologyCode", referencedColumnName="NozologyCode")})
	 */
	protected $nozologies;

	/**
	 * @ORM\ManyToMany(targetEntity="Molecule", inversedBy="arts")
	 * @ORM\JoinTable(name="art_molecule",
	 *        joinColumns={@ORM\JoinColumn(name="art_id", referencedColumnName="id")},
	 *        inverseJoinColumns={@ORM\JoinColumn(name="MoleculeID", referencedColumnName="MoleculeID")})
	 */
	protected $molecules;

	/**
	 * @ORM\ManyToMany(targetEntity="Document", inversedBy="arts")
	 * @ORM\JoinTable(name="art_document",
	 *        joinColumns={@ORM\JoinColumn(name="art_id", referencedColumnName="id")},
	 *        inverseJoinColumns={@ORM\JoinColumn(name="DocumentID", referencedColumnName="DocumentID")})
	 */
	protected $documents;

	/**
	 * @ORM\ManyToMany(targetEntity="ATC", inversedBy="arts")
	 * @ORM\JoinTable(name="art_atc",
	 *        joinColumns={@ORM\JoinColumn(name="art_id", referencedColumnName="id")},
	 *        inverseJoinColumns={@ORM\JoinColumn(name="ATCCode", referencedColumnName="ATCCode")})
	 */
	protected $atcCodes;

	/**
	 * @ORM\ManyToMany(targetEntity="InfoPage", inversedBy="arts")
	 * @ORM\JoinTable(name="art_infopage",
	 *        joinColumns={@ORM\JoinColumn(name="art_id", referencedColumnName="id")},
	 *        inverseJoinColumns={@ORM\JoinColumn(name="InfoPageID", referencedColumnName="InfoPageID")})
	 */
	protected $infoPages;

	/** @ORM\ManyToOne(targetEntity="ArtType", inversedBy="arts") */
	protected $type;

	/** @ORM\Column(type="datetime", nullable=true) */
	protected $date;

	/** @ORM\Column(length=500, nullable=true) */
	protected $synonym;

	/** @ORM\Column(length=255, nullable=true) */
	protected $metaTitle;

	/** @ORM\Column(length=255, nullable=true) */
	protected $metaDescription;

	/** @ORM\Column(length=255, nullable=true) */
	protected $metaKeywords;

	/** @ORM\ManyToOne(targetEntity="Subdivision", inversedBy="articles") */
	protected $subdivision;

	/** @ORM\Column(type="integer", nullable=false) */
	protected $priority;

	/** @ORM\Column(type="integer", nullable=true) */
	protected $subdivisionId;

	/** @ORM\Column(type="integer", nullable=true) */
	protected $subclassId;

	public function __construct()
	{
		$this->nozologies = new ArrayCollection();
		$this->molecules  = new ArrayCollection();
		$this->documents  = new ArrayCollection();
		$this->atcCodes   = new ArrayCollection();
		$this->infoPages  = new ArrayCollection();
		$now              = new \DateTime('now');
		$this->created    = $now;
		$this->updated    = $now;
		$this->date       = $now;
		$this->priority   = 0;
	}

	public function __toString()
	{
		return empty($this->title) ? '' : $this->title;
	}

	/**
	 * @param mixed $announce
	 */
	public function setAnnounce($announce)
	{
		$this->announce = $announce;
	}

	/**
	 * @return mixed
	 */
	public function getAnnounce()
	{
		return $this->announce;
	}

	/**
	 * @param mixed $body
	 */
	public function setBody($body)
	{
		$this->body = $body;
	}

	/**
	 * @return mixed
	 */
	public function getBody()
	{
		return $this->body;
	}

	/**
	 * @param mixed $link
	 */
	public function setLink($link)
	{
		$this->link = $link;
	}

	/**
	 * @return mixed
	 */
	public function getLink()
	{
		return $this->link;
	}

	/**
	 * @param mixed $molecules
	 */
	public function setMolecules($molecules)
	{
		$this->molecules = $molecules;
	}

	/**
	 * @return mixed
	 */
	public function getMolecules()
	{
		return $this->molecules;
	}

	/**
	 * @param mixed $nozologies
	 */
	public function setNozologies($nozologies)
	{
		$this->nozologies = $nozologies;
	}

	/**
	 * @return mixed
	 */
	public function getNozologies()
	{
		return $this->nozologies;
	}

	public function addNozology($nozology)
	{
		$this->nozologies[] = $nozology;

		return $this;
	}

	/**
	 * @param mixed $title
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	}

	/**
	 * @return mixed
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param mixed $type
	 */
	public function setType($type)
	{
		$this->type = $type;
	}

	/**
	 * @return mixed
	 */
	public function getType()
	{
		return $this->type;
	}

	public function addDocument(Document $document)
	{
		$this->documents[] = $document;
	}

	public function removeDocument(Document $document)
	{
		$this->documents->removeElement($document);
	}

	/**
	 * @param mixed $date
	 */
	public function setDate($date)
	{
		$this->date = $date;
	}

	/**
	 * @return mixed
	 */
	public function getDate()
	{
		return $this->date;
	}

	/**
	 * @param mixed $synonym
	 */
	public function setSynonym($synonym)
	{
		$this->synonym = $synonym;
	}

	/**
	 * @return mixed
	 */
	public function getSynonym()
	{
		return $this->synonym;
	}

	/**
	 * @param mixed $metaDescription
	 */
	public function setMetaDescription($metaDescription)
	{
		$this->metaDescription = $metaDescription;
	}

	/**
	 * @return mixed
	 */
	public function getMetaDescription()
	{
		return $this->metaDescription;
	}

	/**
	 * @param mixed $metaKeywords
	 */
	public function setMetaKeywords($metaKeywords)
	{
		$this->metaKeywords = $metaKeywords;
	}

	/**
	 * @return mixed
	 */
	public function getMetaKeywords()
	{
		return $this->metaKeywords;
	}

	/**
	 * @param mixed $metaTitle
	 */
	public function setMetaTitle($metaTitle)
	{
		$this->metaTitle = $metaTitle;
	}

	/**
	 * @return mixed
	 */
	public function getMetaTitle()
	{
		return $this->metaTitle;
	}

	/**
	 * @param mixed $public
	 */
	public function setPublic($public)
	{
		$this->public = $public;
	}

	/**
	 * @return mixed
	 */
	public function getPublic()
	{
		return $this->public;
	}

	/**
	 * @param mixed $subclassId
	 */
	public function setSubclassId($subclassId)
	{
		$this->subclassId = $subclassId;
	}

	/**
	 * @return mixed
	 */
	public function getSubclassId()
	{
		return $this->subclassId;
	}

	/**
	 * @param mixed $subdivisionId
	 */
	public function setSubdivisionId($subdivisionId)
	{
		$this->subdivisionId = $subdivisionId;
	}

	/**
	 * @return mixed
	 */
	public function getSubdivisionId()
	{
		return $this->subdivisionId;
	}

	/**
	 * @param mixed $subdivision
	 */
	public function setSubdivision($subdivision)
	{
		$this->subdivision = $subdivision;
	}

	/**
	 * @return mixed
	 */
	public function getSubdivision()
	{
		return $this->subdivision;
	}

	/**
	 * @param mixed $priority
	 */
	public function setPriority($priority)
	{
		$this->priority = $priority;
	}

	/**
	 * @return mixed
	 */
	public function getPriority()
	{
		return $this->priority;
	}

	/**
	 * @param mixed $documents
	 */
	public function setDocuments($documents)
	{
		$this->documents = $documents;
	}

	/**
	 * @return mixed
	 */
	public function getDocuments()
	{
		return $this->documents;
	}

	/**
	 * @param mixed $atcCodes
	 */
	public function setAtcCodes($atcCodes)
	{
		$this->atcCodes = $atcCodes;
	}

	/**
	 * @return mixed
	 */
	public function getAtcCodes()
	{
		return $this->atcCodes;
	}

	/**
	 * @param mixed $infoPages
	 */
	public function setInfoPages($infoPages)
	{
		$this->infoPages = $infoPages;
	}

	/**
	 * @return mixed
	 */
	public function getInfoPages()
	{
		return $this->infoPages;
	}
}