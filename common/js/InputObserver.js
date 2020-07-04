class InputObserver{
    constructor(els){
        this.DOM = {};
        this.DOM.els = els;
    }
    setEventLinstener() {
        const cb = function(e){
            const keycd = e.keyCode;
            if(keycd != 9){ //Tabキー移動の際は除外
                //親Nodeの取得
                let parent_node = this.parentNode;
                //既に表示されているエラーメッセージを削除
                let err_span = parent_node.querySelectorAll('span.error');
                err_span.forEach(element => {
                    parent_node.removeChild(element);
                });
                this.classList.remove('field_error');

                //チェック処理（今後の拡張に備えて配列で保持する）
                let err_arr = [];
                if(this.dataset.type == 'num' && isNaN(this.value)){
                    err_arr.push([parent_node,this.dataset.type,'error']);
                }
                if(this.dataset.req == 1 && !this.value){
                    err_arr.push([parent_node,'blank','error']);
                }
                if(this.dataset.max && this.value.length > this.dataset.max){
                    err_arr.push([parent_node,'max','error']);
                }
                if(this.dataset.min && this.value.length < this.dataset.min){
                    err_arr.push([parent_node,'min','error']);
                }
                err_arr.forEach(element => {
                    //ErrorMsgをインスタンス化
                    let em = new ErrorMsg(this,element[1],element[2]);
                    em.viewMessage();
                });
            }
        };
        
        //渡ってきたすべてのelsに対してEventListener設定（コールバックでcbを指定）
        this.DOM.els.forEach(element => {
            element.addEventListener('keyup',cb);
        });
    };
}
