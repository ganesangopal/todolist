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
      if (!$todo_status) {
        $node->field_todo_status[] = ['value' => 1];
        $node->save();
        $link = Link::fromTextAndUrl($this->t('TODO List'), Url::fromUri('internal:/todo-list'))->toString();
        drupal_set_message($this->t('Todo list of @node marked as completed successfully.', ['@node' => $node->title, '@link' => $link]), 'status', TRUE);
    }
    else {
      $link = Link::fromTextAndUrl($this->t('TODO List'), Url::fromUri('internal:/todo-list'))->toString();
      drupal_set_message($this->t('Todo list of @node already marked as completed.', ['@node' => $node->title, '@link' => $link]), 'status', TRUE);
    }
  }
    $url = Url::fromUri('internal:/home');
    $response = new RedirectResponse($url->toString());
    $response->send();
  }
}
