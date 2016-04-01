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
use Album\Form\AlbumForm;
use Album\Entity\Album;

class AlbumController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel(
            array(
                'albums' => $this->getServiceLocator()->get('Album\Service\AlbumService')->fetchAll(),
                'titel' => 'Alben',
                'spaltenkoepfe' => array(
                    'Name'
                )
            )
        );
    }

    public function newAction()
    {
        
        $songs = $this->getServiceLocator()->get('Album\Service\SongService')->fetchAll();
        $form = new AlbumForm($songs);

        $form->get('submit')->setValue('Hinzufügen');
        
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $album = new Album();
            $form->setInputFilter($this->getServiceLocator()->get('Album\Service\AlbumService')->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $songsSelect = $this->getServiceLocator()->get('Album\Service\SongService')->searchByIds($form->getData()['songauswahl']);
                
                $album->exchangeArray($form->getData(), $songsSelect);
                $this->getServiceLocator()->get('Album\Service\AlbumService')->save($album);

                // Redirect to list of album
                return $this->redirect()->toRoute('album');

            }
        }

        return array('form' => $form);
    }
    
    public function searchAction()
    {
        return new ViewModel(
            array(
                'albums' => $this->getServiceLocator()->get('Album\Service\AlbumService')->search(),
                'titel' => 'Alben',
                'spaltenkoepfe' => array(
                    'Name'
                )
            )
        );
    }
    
    public function deleteAction()
    {

        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('album');
        }
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');
            
            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getServiceLocator()->get('Album/Service/AlbumService')->deleteById($id);
            }
            return $this->redirect()->toRoute('album');
        }
        
        return array(
            'id'    => $id,
            'album' => $this->getServiceLocator()->get('Album/Service/AlbumService')->searchById($id),
        );
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
            return $this->redirect()->toRoute('album', array('action' => 'new'));
        }
        
        $album = $this->getServiceLocator()->get('Album\Service\AlbumService')->searchById($id);
        
        if (!$album) {
            return $this->redirect()->toRoute('album', array('action' => 'index'));
        }
        
        $form = new AlbumForm();
        $form->bind($album);
        $form->get('submit')->setAttribute('value', 'speichern');
        
        
        if ($request->isPost()) {
            $form->setInputFilter($this->getServiceLocator()->get('Album\Service\AlbumService')->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getServiceLocator()->get('Album\Service\AlbumService')->save($album);
                return $this->redirect()->toRoute('album');
            }
        }
        
        return array(
            'titel' => 'Album editieren',
            'id' => $id,
            'form' => $form,
        );
    }
}
