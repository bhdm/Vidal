<?php

namespace Vidal\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Tests\Extension\Core\DataTransformer\DateTimeToArrayTransformerTest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Vidal\MainBundle\Entity\MarketOrder;

use Vidal\MainBundle\Market\Product;
use Vidal\MainBundle\Market\FindDrug;
use Vidal\MainBundle\Market\Basket;

class MarketController extends Controller{

    protected $shipping = Array(
                        '1' => '100',
                        '2' => '150',
                        '3' => '250',
                        '4' => '400',
                        '6' => '',
                        '10' => '',
                        '11' => '250',
                    );

    protected $shippingTitle = array(
        '1' => 'Курьером по Москве в пределах МКАД - 100 руб.',
        '2' => 'Курьером по Москве за пределами МКАД - 150 руб.',
        '3' => 'Ближнее Подмосковье - 250 руб.',
        '4' => 'Подмосковье - 400 руб.',
        '6' => 'Почтой по России (EMS)',
        '10' => 'Самовывоз',
        '11' => 'Срочная доставка в течение 2-х часов - 250 руб.',
    );
    protected $status = array(
        0 => 'принят',
        1 => 'в обработке',
        2 => 'дозваниваемся',
        3 => 'подтверждён',
        4 => 'доставлен',
        5 => 'отменён',
        6 => 'отправлен',
        7 => 'нет лекарств',
        8 => 'ожидание оплаты',
        9 => 'создаётся оператором',
        10 => 'лекарства заказаны',
        11 => 'недовоз',
        12 => 'возврат от курьеров',
        13 => 'собран',
        14 => 'ожидание товара',
        15 => 'товар проверен',
    );

    /**
     * @Route("/add-to-basket/{code}/{count}", name="add_to_basket", defaults={"count"="1"}, options={"expose"=true})
     * @Template("VidalMainBundle:Market:list.html.twig")
     */
    public function AddToBasket($code, $count = 1){

        $basket = new Basket();

        $product = null;
        $product = $basket->getProduct($code);
        if ($product != null ){
            $product->setCount($product->getCount()+$count);
        }else{
            $pr = $this->getDoctrine()->getRepository('VidalMainBundle:MarketDrug')->findOneByCode($code);
            if ($pr != null){
                $product = new Product();
                $product->setCount($count);
                $product->setTitle($pr->getTitle());
                $product->setCode($pr->getCode());
                $product->setGroupApt($pr->getGroupApt());
                $product->setManufacturer($pr->getManufacturer());
                $product->setPrice($pr->getPrice());
            }
        }
        if ($product != null){
            $basket->setProduct($product);
            $basket->save();
        }

        return $this->redirect($this->get('request')->server->get('HTTP_REFERER'));
    }

    /**
     * @Route("/set-to-basket/{code}/{count}", name="set_to_basket", defaults={"count"="1"}, options={"expose"=true})
     * @Template("VidalMainBundle:Market:list.html.twig")
     */
    public function setToBasket($code, $count = 1){
        $basket = new Basket();

        $product = null;
        $product = $basket->getProduct($code);
        if ($product != null ){
            $product->setCount($count);
        }else{
            $pr = $this->getDoctrine()->getRepository('VidalMainBundle:MarketDrug')->findOneByCode($code);
            if ($pr != null){
                $product = new Product();
                $product->setCount($count);
                $product->setTitle($pr->getTitle());
                $product->setCode($pr->getCode());
                $product->setGroupApt($pr->getGroupApt());
                $product->setPrice($pr->getPrice());
            }
        }
        if ($product != null){
            $basket->setProduct($product);
            $basket->save();
        }

        return $this->redirect($this->get('request')->server->get('HTTP_REFERER'));
    }

    /**
     * @Route("/remove-to-basket/{code}", name="remove_to_basket", options={"expose"=true})
     * @Template("VidalMainBundle:Market:list.html.twig")
     */
    public function removeToBasket($code){
        $basket = new Basket();
        $product = $basket->get($code);
        $basket->remove($product);
        return $this->redirect($this->get('request')->server->get('HTTP_REFERER'));
    }

    /**
     * @Route("/drug-list/{drugId}/{isDocs}", name="drug_list", defaults={"isDocs"="false"}, options={"expose"=true})
     * @Template("VidalMainBundle:Market:list.html.twig")
     */
    public function productListAction( $drugId, $isDocs = 'false' ){
        if ( $isDocs == 'false' ){
            $drug = $this->getDoctrine()->getManager('drug')->getRepository('VidalDrugBundle:Product')->findOneBy(array('ProductID' => $drugId));
        }else{
            $drug = $this->getDoctrine()->getManager('drug')->getRepository('VidalDrugBundle:Document')->findOneBy(array('DocumentID' => $drugId));
        }
        if ($drug){
            $RusName = $drug->getRusName();

            $p    = array('/<sup>(.*?)<\/sup>/i', '/<sub>(.*?)<\/sub>/i');
            $r    = array('', '');

            $title = preg_replace($p, $r, $RusName);
            $first = mb_substr($title,0,2);//первая буква
            $last = mb_substr($title,2);//все кроме первой буквы
            $last = mb_strtolower($last,'UTF-8');
            $title =$first.$last;

            $list = $this->getDoctrine()->getRepository('VidalMainBundle:MarketDrug')->find($title);

            $lists = array();
            foreach ( $list as $drug){
                $lists[$drug->getGroupApt()][] = $drug;
            }
        }else{
            $lists = array();
        }


        return array('lists' => $lists);
    }

    /**
     * @Route("/basket-list", name="basket_list" )
     * @Template("VidalMainBundle:Market:basket_list.html.twig")
     */
    public function basketListAction(){
        $basket = new Basket();
//        $basket->removeAll();
        $products = $basket->getAll();
        $amounts = $basket->getAmounts();
        return array(
            'products' => $products,
            'amounts'  => $amounts,
        );
    }

    /**
     * @Route("/basket-order/{group}", name="basket_order" )
     * @Template("VidalMainBundle:Market:basket_order.html.twig")
     */
    public function basketOrderAction($group){

        $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();
        # генерация формы
        $order   = new MarketOrder();
        $builder = $this->createFormBuilder($order);
        $builder
            ->add('lastName', null, array('label' => 'Фамилия'))
            ->add('firstName', null, array('label' => 'Имя'))
            ->add('surName', null, array('label' => 'Отчество'))
            ->add('email', null, array('label' => 'E-mail'))
            ->add('phone', null, array('label' => 'Телефон'))
            ->add('adress', null, array('label' => 'Адрес'))
            ->add('shipping', 'choice', array('label' => 'Выбор доставки', 'choices' => $this->shippingTitle, 'attr' => array( 'class' => 'delivery-select')))
            ->add('comment', null, array('label' => 'Комментарий к доставке'))
            ->add('groupApt', 'hidden')
            ->add('submit', 'submit', array('label' => 'Отправить заказ', 'attr' => array('class' => 'btn-red')));
        $form    = $builder->getForm();
        $form->handleRequest($request);

        if ($request->isMethod('POST')) {
            if ($form->isValid()){
                $order = $form->getData();
                $order->setShippingPrice($this->shipping[$order->getShipping()]);
                $em->persist($order);
                $em->flush($order);
                $em->refresh($order);

                $xml = $this->generateXml($group, $order);
                $basket = new Basket();
                $this->mailSend($group, $order, $basket);
                $order->setBody($xml);
                $order->setEnabled(true);
                $em->flush($order);

                if ($group != 'zdravzona' ){
                    $url = 'http://smacs.ru/feedbacks/'.md5($group.'_'.$order->getId().'vidal3L29y4');
                    return $this->render("VidalMainBundle:Market:order_success.html.twig",array( 'url' => $url ));
                }else{
                    return $this->render("VidalMainBundle:Market:order_success_2.html.twig");
                }

            }else{
                return array('form' => $form->createView());
            }
        }else{
            return array('form' => $form->createView());
        }

    }

    /**
     * @Route("/basket-count", name="basket_count" )
     * @Template("VidalMainBundle:Market:basket_count.html.twig")
     */
    public function countProductAction(){
        $basket = new Basket();
        $count = $basket->getCount();

        return array('count' => $count );
    }

    /**
     * @Route("/set-to-basket-ajax/{code}/{count}", name="set_to_basket_ajax", defaults={"count"="1"}, options={"expose"=true})
     */
    public function setToBasketAjax($code, $count = 1){
        $basket = new Basket();
        $summa = 0;
        $product = null;
        $product = $basket->getProduct($code);
        if ($product != null ){
            $product->setCount($count);
        }else{
            $pr = $this->getDoctrine()->getRepository('VidalMainBundle:MarketDrug')->findOneByCode($code);
            if ($pr != null){
                $product = new Product();
                $product->setCount($count);
                $product->setTitle($pr->getTitle());
                $product->setCode($pr->getCode());
                $product->setGroup($pr->getGroup());
                $product->setPrice($pr->getPrice());
            }
        }
        if ($product != null){
            $basket->setProduct($product);
            $basket->save();
            $product = $basket->getProduct($code);

            $summa = $product->getPrice() * $product->getCount();
            $summa =  number_format($summa,2,'.',',');
            $summaAll = $basket->getSumma();
            $s1 = number_format(( isset($summaAll['eapteka']) ? $summaAll['eapteka'] : 0 ),2,'.',',');
            $s2 = number_format(( isset($summaAll['piluli']) ? $summaAll['piluli'] : 0 ),2,'.',',');
            $s3 = number_format(( isset($summaAll['zdravzona']) ? $summaAll['zdravzona'] : 0 ),2,'.',',');
        }
        return new Response($summa.'|'.$s1.'|'.$s2.'|'.$s3);
    }


    public function generateXml($group, $order){

        $basket = new Basket();
        $products = $basket->getAll();
        $products = $products[$group];

        $header = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
                    <orders>
                        <order>
	                        <order_code>".   $order->getId()."_1234</order_code>
	                        <name>".         $order->getLastName()." ".$order->getFirstName()." ".$order->getSurName()."</name>
                            <phone>".        $order->getPhone()."</phone>
                            <email>".        $order->getEmail()."</email>
                            <address>".      $order->getAdress()."</address>
                            <comment>".      $order->getComment()."</comment>
                            <shipping_id>".  $order->getShipping()."</shipping_id>
                            <shipping_cost>".$this->shipping[$order->getShipping()]."</shipping_cost>
                            <payment_id>".   $order->getId()."</payment_id>
                            <discount>0</discount>
                            <total_cost>156.93</total_cost>
                            <order_time>".   time($order->getCreated())."</order_time>
                            <products>";

        $footer = "         </products>
                        </order>
                    </orders>";

        $xml = '';
        foreach ( $products as $product){
            $xml .= "            <product>
                                    <code>".$product->getCode()."</code>
                                    <name>".$product->getTitle()."</name>
                                    <amount>".$product->getCount()."</amount>
                                    <price>".$product->getPrice()."</price>
                                </product>";
        }

        return $header.$xml.$footer;
    }


    public function mailSend($group, $order,Basket $basket){
        $summa = $basket->getAmounts();
        $summa = $summa[$group];
        $basket = $basket->getAll();
        $basket = $basket[$group];
        # уведомление магазина о покупке
        $this->get('email.service')->send(
//            "zakaz@zdravzona.ru",
              "tulupov.m@gmail.com",
            array('VidalMainBundle:Email:market_notice.html.twig', array('group' => $group, 'order' => $order, 'basket' => $basket, 'summa' => $summa )),
            'Покупка с сайта Vidal.ru'
        );

        $this->get('email.service')->send(
//            "zakaz@zdravzona.ru",
            "tulupov.m@gmail.com",
            array('VidalMainBundle:Email:market_notice_user.html.twig', array('group' => $group, 'order' => $order, 'basket' => $basket, 'summa' => $summa )),
            'Покупка с сайта Vidal.ru'
        );
    }


}
