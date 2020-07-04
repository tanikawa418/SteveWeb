class ErrorMsg{
    constructor(target, type, level){
        //Nodeでもセレクタ文字列でも受け取れるようにしておく
        this.el = target instanceof HTMLElement ? target : document.querySelector(target);
        this.parent = this.el.parentNode;
        this.type = type;
        this.level = level;
        this.min = this.el.dataset.min;
        this.max = this.el.dataset.max;
        this.msg = this._getMessage(type);
    }
    _getMessage(type){
        if(type == 'num'){return '数値で入力してください'};
        if(type == 'blank'){return '入力必須です!!'};
        if(type == 'max'){return `長すぎです。${this.max}文字以内で入力してください。`};
        if(type == 'min'){return `短すぎです。${this.min}文字以内で入力してください。`};
    }
    viewMessage(){
        let msg_el = document.createElement('span');
        msg_el.className = this.level;
        msg_el.dataset.err_type = this.type;
        msg_el.innerHTML = this.msg;
        this.parent.appendChild(msg_el);
        this.el.classList.add('field_error');
    }
}
