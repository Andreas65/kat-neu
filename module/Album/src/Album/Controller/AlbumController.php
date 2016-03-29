<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Album\Service\AlbumService;

class AlbumController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel(
            array(
                'albums' => $this->getServiceLocator()->get('Album\Service\AlbumService')->fetchAll(),
                'titel' => 'Artisten',
                'spaltenkoepfe' => array(
                    'Name', 'Genre', 'Anzahl der Alben'
                )
            )
        );
    }
    

    public function newAction()
    {
        //$id2 = $this->getParameter('portals');
        //$id = $this->getParam('id');
        return new ViewModel(
            array(
                 'albums' => $this->getServiceLocator()->get('Album\Service\AlbumService')->fetchAll(),
            )
        );
    }
    
    public function searchAction()
    {
        return new ViewModel(
            array(
                'albums' => $this->getServiceLocator()->get('Album\Service\AlbumService')->search(),
                'titel' => 'Artisten',
                'spaltenkoepfe' => array(
                    'Name', 'Genre', 'Anzahl der Alben'
                )
            )
        );
    }
    public function deleteAction()
    {
        return new ViewModel(
            array(
                'albums' => $this->getServiceLocator()->get('Album\Service\AlbumService')->fetchAll(),
                'titel' => 'Artisten',
                'spaltenkoepfe' => array(
                    'Name', 'Genre', 'Anzahl der Alben'
                )
            )
        );
    }
}
