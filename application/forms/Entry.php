<?php

class Form_Entry extends Zend_Form
{

    public function init()
    {
        $this->setName("entry-form")
             ->setMethod("post");

        $category = new Zend_Form_Element_Select("category");
        $category->class = "text";
        $category->setLabel("Customer:") 
            ->setRequired();
        $category->addMultiOptions(array(
                    0 => "Select"
                ));

      
        $customerInfo = new Zend_Form_Element_Textarea("customerInfo");
        $customerInfo->class = "text";
        $customerInfo->setLabel("Customer Info:")
                ->setRequired()
                ->setAttrib("cols", "30")
                ->setAttrib("rows", "5")
                ->addFilters(array("StringTrim","StringToLower"));                


        $visitTime = new Zend_Form_Element_Text("visitTime");
        $visitTime->class = "text";
        $visitTime->setLabel("Visiting TIme:")
                ->setRequired()
                ->addFilters(array("StringTrim","StringToLower"));                


        $area = new Zend_Form_Element_Select("area");
        $area->class = "text";
        $area->setLabel("Area:")
                ->setRequired();
        $area->addMultiOptions(array(
             0 => "Select"
        ));
        $area->setValue(0);

        $city = new Zend_Form_Element_Select("city");
        $city->class = "text";
        $city->setLabel("City:")
                ->setRequired();
        $city->addMultiOptions(array(
             0 => "Select"
        ));
        $city->setValue(0);
        
        $activity = new Zend_Form_Element_Textarea("activity");
        $activity->class = "text";
        $activity->setLabel("Activity:")
                 ->setRequired()
                 ->setAttrib("cols", "30")
                 ->setAttrib("rows", "5")
                 ->addFilter("StringTrim", "StringToLower");


        $result = new Zend_Form_Element_Select("result");
        $result->class = "text";
        $result->setLabel("Result:")
                ->setRequired(false);
        $result->addMultiOptions(array(
            "incomplete" => "incomplete",
            "success" => "success",
            "fail" => "fail",
        ));
        $result->setValue("incomplete");
        

        $remarks = new Zend_Form_Element_Textarea("remarks");
        $remarks->class = "text";
        $remarks->setLabel("Remarks:")
               ->setRequired(false)
               ->setAttrib("cols", "30")
               ->setAttrib("rows", "5")               
               ->addFilter("StringTrim", "StringToLower");

        
        $submit = new Zend_Form_Element_Submit("submit");
        $submit->class = "novisible1";
        $submit->setDecorators(array(
                "ViewHelper",
                "Description",
                "Errors",
                array("HtmlTag", array("tag" => "div", "class" => "submit-row"))
        ));

        $elements = array(
            $category,
            $customerInfo,
            $visitTime,
            $area,
            $city,
            $activity,
            $result,
            $remarks
        );

        foreach($elements as $element)
        {
            $element->setDecorators(array(
                "ViewHelper",
                "Description",
                "Errors",
                array("Label"),
                array("HtmlTag", array("tag" => "div", "class" => "form-row"))
            ));
        }

        // add data elements
        $this->addElements($elements);
        // add submit buttons
        $this->addElement($submit);

        $this->setDecorators(array(
            "FormElements",
            array("HtmlTag", array("tag" => "div")),
            "Form"
        ));
        
    }

}