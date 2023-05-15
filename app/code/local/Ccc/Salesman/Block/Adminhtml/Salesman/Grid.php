<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright  Copyright (c) 2006-2020 Magento, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Adminhtml customer grid block
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Ccc_Salesman_Block_Adminhtml_Salesman_Grid extends Mage_Adminhtml_Block_Widget_Grid
{


    public function __construct()
    {
        parent::__construct();
        $this->setId('salesmanAdminhtmlSalesmanGrid');
        $this->setDefaultSort('salesman_id');
        $this->setDefaultDir('ASC');
    }

   protected function _prepareCollection()
    {
        $collection = Mage::getModel('salesman/salesman')->getCollection();
        // echo "<pre>";print_r($collection);
        /* @var $collection Mage_Cms_Model_Mysql4_Page_Collection */
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('salesman_id', array(
            'header'    => Mage::helper('salesman')->__('Salesman Id'),
            'align'     => 'left',
            'index'     => 'salesman_id',
        ));

        $this->addColumn('first_name', array(
            'header'    => Mage::helper('salesman')->__('First Name'),
            'align'     => 'left',
            'index'     => 'first_name',
        ));

        $this->addColumn('last_name', array(
            'header'    => Mage::helper('salesman')->__('Last Name'),
            'align'     => 'left',
            'index'     => 'last_name',
        ));

        $this->addColumn('email', array(
            'header'    => Mage::helper('salesman')->__('Email'),
            'align'     => 'left',
            'index'     => 'email'
        ));

        $this->addColumn('mobile', array(
            'header'    => Mage::helper('salesman')->__('Mobile'),
            'align'     => 'left',
            'index'     => 'mobile'
        ));

        $this->addColumn('gender', array(
            'header'    => Mage::helper('salesman')->__('Gender'),
            'align'     => 'left',
            'index'     => 'gender'
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('salesman')->__('Status'),
            'align'     => 'left',
            'index'     => 'status'
        ));

        $this->addColumn('company', array(
            'header'    => Mage::helper('salesman')->__('Company'),
            'align'     => 'left',
            'index'     => 'company'
        ));

        $this->addColumn('create_date', array(
            'header'    => Mage::helper('salesman')->__('Create Time'),
            'align'     => 'left',
            'index'     => 'create_date'
        ));

        $this->addColumn('updated_date', array(
            'header'    => Mage::helper('salesman')->__('Updated Time'),
            'align'     => 'left',
            'index'     => 'updated_date'
        ));

        return parent::_prepareColumns();
    }

     protected function _prepareMassaction()
    {
        $this->setMassactionIdField('salesman_id');
        $this->getMassactionBlock()->setFormFieldName('salesman');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('salesman')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('salesman')->__('Are you sure?')
        ));

        // $this->getMassactionBlock()->addItem('newsletter_subscribe', array(
        //      'label'    => Mage::helper('customer')->__('Subscribe to Newsletter'),
        //      'url'      => $this->getUrl('*/*/massSubscribe')
        // ));

        // $this->getMassactionBlock()->addItem('newsletter_unsubscribe', array(
        //      'label'    => Mage::helper('customer')->__('Unsubscribe from Newsletter'),
        //      'url'      => $this->getUrl('*/*/massUnsubscribe')
        // ));

        // $groups = $this->helper('salesman')->getGroups()->toOptionArray();

        // array_unshift($groups, array('label'=> '', 'value'=> ''));
        // $this->getMassactionBlock()->addItem('assign_group', array(
        //      'label'        => Mage::helper('salesman')->__('Assign a Salesman Group'),
        //      'url'          => $this->getUrl('*/*/massAssignGroup'),
        //      'additional'   => array(
        //         'visibility'    => array(
        //              'name'     => 'group',
        //              'type'     => 'select',
        //              'class'    => 'required-entry',
        //              'label'    => Mage::helper('salesman')->__('Group'),
        //              'values'   => $groups
        //          )
        //     )
        // ));

        return $this;
    }

    /**
     * Row click url
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('salesman_id' => $row->getId()));
    }
   
}