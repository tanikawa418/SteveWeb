class TextAnimation {
    constructor(el) {
        this.DOM = {};
        //DOMでもセレクター文字列でも受け取れるようにする
        this.DOM.el = el instanceof HTMLElement ? el : document.querySelector(el);
        this.chars = this.DOM.el.innerHTML.trim().split("");
        //thisのhtmlを、1文字ずつ分割したcharクラスのspanに置き換える
        this.DOM.el.innerHTML = this._splitText();
    }
    _splitText() {
        return this.chars.reduce((acc, curr) => {
            curr = curr.replace(/\s+/, '&nbsp;');
            return `${acc}<span class="char">${curr}</span>`;
        }, "");
    }
    animate() {
        this.DOM.el.classList.toggle('startAnimation');
    }
}