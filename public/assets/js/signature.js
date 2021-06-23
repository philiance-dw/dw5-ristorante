const canvasElement = document.getElementById('canvas');

class Canvas {
  isDrawing = false;
  canvas = null;
  x = 0;
  y = 0;

  constructor(canvasElement) {
    this.canvas = canvasElement;
    this.ctx = this.canvas.getContext('2d');
  }

  init = () => {
    this.attachListeners();
    this.initCanvas();
  };

  initCanvas = () => {
    this.ctx.clearRect(0, 0, window.innerWidth, window.innerHeight);

    this.ctx.fillStyle = '#fff';
    this.ctx.fillRect(0, 0, window.innerWidth, window.innerHeight);
  };

  attachListeners = () => {
    this.canvas.addEventListener('mousedown', this.startDrawing);
    this.canvas.addEventListener('mouseup', this.stopDrawing);
    this.canvas.addEventListener('mousemove', this.draw);
    this.canvas.addEventListener('mouseout', this.stopDrawing);
  };

  draw = (event) => {
    if (this.isDrawing) {
      const { ctx } = this;

      const newX = event.offsetX;
      const newY = event.offsetY;

      ctx.beginPath();
      ctx.moveTo(this.x, this.y);
      ctx.lineTo(newX, newY);
      ctx.stroke();
      this.x = newX;
      this.y = newY;
    }
  };
  startDrawing = (event) => {
    this.isDrawing = true;
    this.x = event.offsetX;
    this.y = event.offsetY;
  };

  stopDrawing = (event) => {
    this.isDrawing = false;
  };

  save = () => {
    const link = document.createElement('a');
    link.download = 'signature.png';
    link.href = document.getElementById('canvas').toDataURL();
    link.click();
  };

  send = (event) => {
    event.preventDefault();
    this.canvas.toBlob((blob) => {
      const file = new File([blob], 'signature.png', {
        lastModified: new Date(),
        type: blob.type,
      });

      const form = new FormData(event.target);
      form.append('file', file);

      // affiche les données du formulaire
      for (const pair of form.entries()) {
        console.log(pair[0] + ', ' + pair[1]);
      }

      // uncomment this to send to server
      // event.target.submit();
    });
  };
}

const canvas = new Canvas(canvasElement);
canvas.init();

const saveBtn = document.querySelector('button[type="button"]');
saveBtn.addEventListener('click', canvas.save);

const resetBtn = document.querySelector('button[type="reset"]');
resetBtn.addEventListener('click', canvas.initCanvas);

const formElement = document.querySelector('form');
formElement.addEventListener('submit', canvas.send);
