"use strict";
class Canvas {
    constructor(canvasElement) {
        var _a;
        this.isDrawing = false;
        this.x = 0;
        this.y = 0;
        this.ctx = null;
        this.init = () => {
            this.attachListeners();
            this.initCanvas();
        };
        this.initCanvas = () => {
            var _a, _b;
            (_a = this.ctx) === null || _a === void 0 ? void 0 : _a.clearRect(0, 0, window.innerWidth, window.innerHeight);
            if (this.ctx) {
                this.ctx.fillStyle = '#fff';
            }
            (_b = this.ctx) === null || _b === void 0 ? void 0 : _b.fillRect(0, 0, window.innerWidth, window.innerHeight);
        };
        this.attachListeners = () => {
            var _a, _b, _c, _d;
            (_a = this.canvas) === null || _a === void 0 ? void 0 : _a.addEventListener('mousedown', this.startDrawing);
            (_b = this.canvas) === null || _b === void 0 ? void 0 : _b.addEventListener('mouseup', this.stopDrawing);
            (_c = this.canvas) === null || _c === void 0 ? void 0 : _c.addEventListener('mousemove', this.draw);
            (_d = this.canvas) === null || _d === void 0 ? void 0 : _d.addEventListener('mouseout', this.stopDrawing);
        };
        this.draw = (event) => {
            if (this.isDrawing) {
                const { ctx } = this;
                const newX = event.offsetX;
                const newY = event.offsetY;
                ctx === null || ctx === void 0 ? void 0 : ctx.beginPath();
                ctx === null || ctx === void 0 ? void 0 : ctx.moveTo(this.x, this.y);
                ctx === null || ctx === void 0 ? void 0 : ctx.lineTo(newX, newY);
                ctx === null || ctx === void 0 ? void 0 : ctx.stroke();
                this.x = newX;
                this.y = newY;
            }
        };
        this.startDrawing = (event) => {
            this.isDrawing = true;
            this.x = event.offsetX;
            this.y = event.offsetY;
        };
        this.stopDrawing = (event) => {
            this.isDrawing = false;
        };
        this.save = () => {
            var _a;
            const link = document.createElement('a');
            link.download = 'signature.png';
            const linkHref = (_a = document.getElementById('canvas')) === null || _a === void 0 ? void 0 : _a.toDataURL();
            if (linkHref) {
                link.href = linkHref;
            }
            link.click();
        };
        this.send = (event) => {
            var _a;
            event.preventDefault();
            (_a = this.canvas) === null || _a === void 0 ? void 0 : _a.toBlob((blob) => {
                if (blob) {
                    const file = new File([blob], 'signature.png', {
                        lastModified: new Date().getTime(),
                        type: blob.type,
                    });
                    const form = new FormData(event.target);
                    form.append('file', file);
                    // affiche les données du formulaire
                    // for (const pair of form.entries()) {
                    //   console.log(pair[0] + ', ' + pair[1]);
                    // }
                    // uncomment this to send to server
                    // event.target.submit();
                }
            });
        };
        this.canvas = canvasElement;
        this.ctx = (_a = this.canvas) === null || _a === void 0 ? void 0 : _a.getContext('2d');
    }
}
const canvasElement = document.getElementById('canvas');
if (canvasElement) {
    const canvas = new Canvas(canvasElement);
    canvas.init();
    const saveBtn = document.querySelector('button#save');
    saveBtn === null || saveBtn === void 0 ? void 0 : saveBtn.addEventListener('click', canvas.save);
    const resetBtn = document.querySelector('button#reset');
    resetBtn === null || resetBtn === void 0 ? void 0 : resetBtn.addEventListener('click', canvas.initCanvas);
    const formElement = document.querySelector('form#signature-form');
    formElement === null || formElement === void 0 ? void 0 : formElement.addEventListener('submit', canvas.send);
}
