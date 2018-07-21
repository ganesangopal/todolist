<?php

namespace Drupal\todo_custom\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Url;
use Drupal\Core\Link;

/**
 * Controller for todo custom features.
 */
class TodoCustomController extends ControllerBase {

  /**
    * @param $nid
    *  Nid of the node entity.
    *
    * @return
    *  Redirect Response to previous url.
    */
  public function updateTodoStatus($nid) {
    $uid = \Drupal::currentUser()->id();
    if ($uid && $nid && is_numeric($nid)) {
      $node = Node::load($nid);
      $todo_status = $node->get('field_todo_status')->getValue();
      if (!$todo_status[0]['value']) {
        $node->field_todo_status[] = ['value' => 1];
        $node->save();
        drupal_set_message($this->t('Todo list of @node marked as completed successfully.', ['@node' => $node->title]), 'status', TRUE);
    }
    else {
      drupal_set_message($this->t('Todo list of @node already marked as completed.', ['@node' => $node->title]), 'status', TRUE);
    }
  }
    $url = Url::fromUri('internal:/todo-list');
    $response = new RedirectResponse($url->toString());
    $response->send();
  }
}
