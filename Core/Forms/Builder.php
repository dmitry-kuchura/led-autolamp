<?php
    namespace Forms;

    use Core\HTML;
    use Core\Text;

    class Builder {

        public static function open(array $attributes = NULL)
        {
            if(!isset($attributes['id']))
            {
                $attributes['id'] = 'myForm';
            }
            $classes = array('rowSection', 'validat');
            if(isset($attributes['class']))
            {
                if(is_array($attributes['class']))
                {
                    $classes = array_merge($classes, $attributes['class']);
                }
                else
                {
                    $classes[] = $attributes['class'];
                }
            }
            $attributes['class'] = $classes;
            if(!isset($attributes['method']))
            {
                $attributes['method'] = 'POST';
            }
            if(!isset($attributes['enctype']))
            {
                $attributes['enctype'] = 'multipart/form-data';
            }
            return Form::open($attributes);
        }

        public static function alias(array $attributes = NULL, $labelOptions = false) {
            $attributes = Builder::req($attributes);
            $attributes['class'][] = 'translitConteiner';
            $input = '<div class="input-group">';
            $input .= Form::input($attributes);
            $input .= '<span class="input-group-btn">';
            $input .= Form::button('Заполнить автоматически', array('class' => 'btn translitAction', 'type' => 'button'));
            $input .= '</span>';
            $input .= '</div>';
            if($labelOptions === false)
            {
                return $input;
            }
            $label = Builder::label($attributes, $labelOptions);
            return $label.$input;
        }

        public static function input(array $attributes = NULL, $labelOptions = false)
        {
            $attributes = Builder::req($attributes);
            $input = Form::input($attributes);
            if($labelOptions === false)
            {
                return $input;
            }
            $label = Builder::label($attributes, $labelOptions);
            return $label.$input;
        }

        public static function hidden(array $attributes = NULL, $labelOptions = false)
        {
            $attributes['type'] = 'hidden';
            return Builder::input($attributes, $labelOptions);
        }

        public static function password(array $attributes = NULL, $labelOptions = false)
        {
            $attributes['type'] = 'password';
            return Builder::input($attributes, $labelOptions);
        }

        public static function file(array $attributes = NULL, $labelOptions = false)
        {
            $attributes['type'] = 'file';
            return Builder::input($attributes, $labelOptions);
        }

        public static function checkbox($checked = false, array $attributes = NULL, $labelOptions = false)
        {
            if($checked)
            {
                $attributes[] = 'checked';
            }
            $attributes['type'] = 'checkbox';
            return Builder::input($attributes, $labelOptions);
        }

        public static function radio($checked = false, array $attributes = NULL, $labelOptions = false)
        {
            if($checked)
            {
                $attributes[] = 'checked';
            }
            $attributes['type'] = 'radio';
            return Builder::input($attributes, $labelOptions);
        }

        public static function bool($checked, $name = NULL, $text = NULL) {
            $status = '<label class="control-label">'.($text ?: 'Опубликовано').'</label>';
            $status .= '<label class="checkerWrap-inline">';
            $status .= Builder::radio(! (bool) $checked, array('name' => $name ?: 'status', 'value' => 0));
            $status .= 'Нет';
            $status .= '</label>';
            $status .= '<label class="checkerWrap-inline">';
            $status .= Builder::radio((bool) $checked, array('name' => $name ?: 'status', 'value' => 1));
            $status .= 'Да';
            $status .= '</label>';
            return $status;
        }

        public static function textarea(array $attributes = NULL, $labelOptions = false)
        {
            $attributes = Builder::req($attributes);
            $body = '';
            if(isset($attributes['value']))
            {
                $body = $attributes['value'];
                unset($attributes['value']);
            }
            $textarea = Form::textarea($body, $attributes);
            if($labelOptions === false)
            {
                return $textarea;
            }
            $label = Builder::label($attributes, $labelOptions);
            return $label.$textarea;
        }

        public static function tiny(array $attributes = NULL, $labelOptions = false)
        {
            $tinyClass = 'tinymceEditor';
            if(!isset($attributes['class']))
            {
                $attributes['class'] = $tinyClass;
            }
            else if(is_array($attributes['class']))
            {
                $attributes['class'][] = $tinyClass;
            }
            else
            {
                $attributes['class'] = array($attributes['class'], $tinyClass);
            }
            if(!isset($attributes['style']))
            {
                $attributes['style'] = 'height: 400px;';
            }
            return Builder::textarea($attributes, $labelOptions);
        }

        public static function select($options = NULL, $selected = NULL, array $attributes = NULL, $labelOptions = false)
        {
            $attributes = Builder::req($attributes);
            $select = Form::select($options, $selected, $attributes);
            if($labelOptions === false)
            {
                return $select;
            }
            $label = Builder::label($attributes, $labelOptions);
            return $label.$select;
        }

        public function label(array $attributes = NULL, $labelOptions = false) {
            if($labelOptions === NULL || !$labelOptions)
            {
                $label = Form::label(NULL, array(
                    'for' => $attributes['id'],
                    'class' => 'control-label',
                ));
            }
            else
            {
                $labelText = NULL;
                if(is_string($labelOptions))
                {
                    $labelText = $labelOptions;
                    $labelOptions = array();
                }
                if(!is_array($labelOptions)) {
                    $labelOptions = array();
                }
                if(isset($labelOptions['text']))
                {
                    $labelText = $labelOptions['text'];
                    unset($labelOptions['text']);
                }
                if(isset($labelOptions['tooltip']))
                {
                    $labelText .= '&nbsp;<i class="fa-info-circle text-info bs-tooltip nav-hint" title="'.HTML::chars($labelOptions['tooltip']).'"></i>';
                    unset($labelOptions['tooltip']);
                }
                if(!isset($labelOptions['for']))
                {
                    $labelOptions['for'] = $attributes['id'];
                }
                $classes = array('control-label');
                if(isset($labelOptions['class']))
                {
                    if(is_array($labelOptions['class']))
                    {
                        $classes = array_merge($classes, $labelOptions['class']);
                    }
                    else
                    {
                        $classes[] = $labelOptions['class'];
                    }
                }
                $labelOptions['class'] = $classes;
                $label = Form::label($labelText, $labelOptions);
            }
            return $label;
        }

        public static function req(array $attributes = NULL) {
            if(!isset($attributes['name']))
            {
                if(!isset($attributes['data-name']))
                {
                    if(!isset($attributes['id']))
                    {
                        $attributes['name'] = Text::random();
                    }
                    else
                    {
                        $attributes['name'] = $attributes['id'];
                    }
                }
                else
                {
                    $attributes['name'] = $attributes['data-name'];
                }
            }
            if(!isset($attributes['data-name']))
            {
                $attributes['data-name'] = $attributes['name'];
            }
            if(!isset($attributes['id'])) {
                $attributes['id'] = 'f_'.strtolower(preg_replace('/[^a-zA-Z_-]/', '', $attributes['name']));
            }
            $classes = array('form-control');
            if(isset($attributes['class']))
            {
                if(is_array($attributes['class']))
                {
                    $classes = array_merge($classes, $attributes['class']);
                }
                else
                {
                    $classes[] = $attributes['class'];
                }
            }
            $attributes['class'] = $classes;
            return $attributes;
        }

    }

