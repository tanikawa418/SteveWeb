function deleteConfirm(){
    if(window.confirm("本当に削除しますか？アップロードした画像も削除されます。")){
        return true;
    }else{
        window.alert('キャンセルしました');
        return false;
    }
}
