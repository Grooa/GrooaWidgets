<?php

namespace Plugin\GrooaWidgets\Form;

use Ip\Form;

class GenericWidgetForm {

    protected function setupManagementForm(string $validationMethodName, ?array $widgetData = []): Form
    {
        $form = new Form();

        $form->setEnvironment(Form::ENVIRONMENT_ADMIN);

        //setting hidden input field so that this form would be submitted to 'errorCheck' method of this controller. (http://www.impresspages.org/docs/controller)
        $form->addField(new Form\Field\Hidden(
            array(
                'name' => 'aa',
                'value' => 'GrooaWidgets.' . $validationMethodName
            )
        ));

        return $form;
    }
}
