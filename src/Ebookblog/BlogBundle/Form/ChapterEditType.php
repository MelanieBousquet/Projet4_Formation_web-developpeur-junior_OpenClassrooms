<?php

namespace Ebookblog\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ChapterEditType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {

  }

  public function getParent()
  {
    return ChapterType::class;
  }
}
