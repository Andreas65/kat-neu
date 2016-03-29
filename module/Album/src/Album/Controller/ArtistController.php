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
use Album\Service\ArtistService;
use Album\Form\ArtistForm;
use Album\Entity\Artist;

class ArtistController extends AbstractActionController
{

    public function indexAction()
    {
//        $albums = $this->getServiceLocator()->get('Album\Service\ArtistService')->fetchAll();
        
//        \Zend\Debug\Debug::dump($albums, basename(__FILE__) . ':' . __LINE__);
//        die;
        
        return new ViewModel(
            array(
                'artisten' => $this->getServiceLocator()->get('Album\Service\ArtistService')->fetchAll(),
                'titel' => 'Artisten',
                'spaltenkoepfe' => array(
                    'Name', 'Genre', 'Anzahl der Alben'
                )
            )
        );
    }

    public function newAction()
    {
        $form = new ArtistForm();

        $form->get('submit')->setValue('Hinzufügen');
        
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $artist = new Artist();
            $form->setInputFilter($this->getServiceLocator()->get('Album\Service\ArtistService')->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $artist->exchangeArray($form->getData());
                $this->getServiceLocator()->get('Album\Service\ArtistService')->save($artist);

                // Redirect to list of artist
                return $this->redirect()->toRoute('artist');

            }
        }

        return array('form' => $form);
    }
    
    public function searchAction()
    {
        return new ViewModel(
            array(
                'artisten' => $this->getServiceLocator()->get('Album\Service\ArtistService')->search(),
                'titel' => 'Artisten',
                'spaltenkoepfe' => array(
                    'Name', 'Genre', 'Anzahl der Alben'
                )
            )
        );
    }
    
    public function deleteAction()
    {

        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('artist');
        }
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');
            
            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getServiceLocator()->get('Album/Service/ArtistService')->deleteById($id);
            }
            return $this->redirect()->toRoute('artist');
        }
        
        return array(
            'id'    => $id,
            'artist' => $this->getServiceLocator()->get('Album/Service/ArtistService')->searchById($id),
        );
//        return new ViewModel(
//            array(
//                'artisten' => $this->getServiceLocator()->get('Album\Service\ArtistService')->fetchAll(),
//                'titel' => 'Artisten',
//                'spaltenkoepfe' => array(
//                    'Name', 'Genre', 'Anzahl der Alben'
//                )
//            )
//        );
    }
    
    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        //$id = (int) $this->getEvent()->getRouteMatch()->getParam('id');

        $request = $this->getRequest();
        if (!$id) {
            if ($request->isPost()) {
                $data = $request->getPost();
                $id = isset($data['id']) ? $data['id'] : 0;
            }
        }
        
        if (!$id) {
            return $this->redirect()->toRoute('artist', array('action' => 'new'));
        }
        
        $artist = $this->getServiceLocator()->get('Album\Service\ArtistService')->searchById($id);
        
        if (!$artist) {
            return $this->redirect()->toRoute('artist', array('action' => 'index'));
        }
        
        $form = new ArtistForm();
        $form->bind($artist);
        $form->get('submit')->setAttribute('value', 'speichern');
        
        
        if ($request->isPost()) {
            $form->setInputFilter($this->getServiceLocator()->get('Album\Service\ArtistService')->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getServiceLocator()->get('Album\Service\ArtistService')->save($artist);
                return $this->redirect()->toRoute('artist');
            }
        }
        
        return array(
            'titel' => 'Artist editieren',
            'id' => $id,
            'form' => $form,
        );
    }
    
    
    
}
