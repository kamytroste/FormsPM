<?php

namespace formspm\kamy;

enum FormType: string {
    case SIMPLE_FORM = 'form';
    case MODAL_FORM = 'modal';
    case CUSTOM_FORM = 'custom_form';
}
