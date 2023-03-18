<?php
/**
 * @return string
 */
function getLogo(){
    return 'https://static.iconarchive.com/static/images/ia/logo/logo.png';
}

/**
 * @param $image
 * @return mixed|string
 */
function getAdminImage($image){
    if($image)
        return get_user_lang('Admin',$image);
    return defaultImages(2);
}


function getCurrency(){
    return 'LE';
}

function getNameInIndexPage(){
    return 'كوبونات';
}


function getMoneyModelType($type){
    if($type == 1)
        $name='يومية';
    if($type == 5)
        $name='فواتير';
    if($type == 4)
        $name='موظفين';

    return $name;
}

/**
 * @param $type
 * @return string
 */
function getIcon($type){
    if($type ==1)
        return 'sl-icon-wrench';
    if($type==2)
        return  'sl-icon-trash';
    if($type==3)
        return  'icon-Eye-Visible';
}

function getCounts($model){
    return $model->count();
}


