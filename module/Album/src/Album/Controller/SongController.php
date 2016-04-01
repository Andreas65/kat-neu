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
use Album\Service\SongService;
use Album\Form\SongForm;
use Album\Entity\Song;
use Traversable;
use Zend\Stdlib\ArrayUtils;

class SongController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel(
            array(
                'songs' => $this->getServiceLocator()->get('Album\Service\SongService')->fetchAll(),
                'titel' => 'Songs',
                'spaltenkoepfe' => array(
                    'Name', 'Artist'
                )
            )
        );
    }

    public function newAction()
    {
        $form = new SongForm();

        $form->get('submit')->setValue('Hinzufügen');
        
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $song = new Song();
            $form->setInputFilter($this->getServiceLocator()->get('Album\Service\SongService')->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $song->exchangeArray($form->getData());
                $this->getServiceLocator()->get('Album\Service\SongService')->save($song);

                // Redirect to list of artist
                return $this->redirect()->toRoute('song');

            }
        }

        return array('form' => $form);
    }
    
    public function searchAction()
    {
        return new ViewModel(
            array(
                'songs' => $this->getServiceLocator()->get('Album\Service\SongService')->search(),
                'titel' => 'Songs',
                'spaltenkoepfe' => array(
                    'Name', 'Artist'
                )
            )
        );
    }
    
    public function deleteAction()
    {

        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('song');
        }
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');
            
            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getServiceLocator()->get('Album/Service/SongService')->deleteById($id);
            }
            return $this->redirect()->toRoute('song');
        }
        
        return array(
            'id'    => $id,
            'song' => $this->getServiceLocator()->get('Album/Service/SongService')->searchById($id),
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
            return $this->redirect()->toRoute('song', array('action' => 'new'));
        }
        
        $song = $this->getServiceLocator()->get('Album\Service\SongService')->searchById($id);

        if (!$song) {
            return $this->redirect()->toRoute('song', array('action' => 'index'));
        }
        
        $form = new SongForm();
        $form->bind($song);
        $form->get('submit')->setAttribute('value', 'speichern');
        
        
        if ($request->isPost()) {
            $form->setInputFilter($this->getServiceLocator()->get('Album\Service\SongService')->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                if ($data instanceof Traversable) {
                    $data = ArrayUtils::iteratorToArray($data);
                    $song->exchangeArray($data);
                }
                $this->getServiceLocator()->get('Album\Service\SongService')->save($song);
                return $this->redirect()->toRoute('song');
            }
        }
        
        return array(
            'titel' => 'Song editieren',
            'id' => $id,
            'form' => $form,
        );
    }
}
