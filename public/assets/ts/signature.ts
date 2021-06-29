class Canvas {
  private isDrawing = false;
  private canvas: HTMLCanvasElement;
  private x = 0;
  private y = 0;
  private ctx?: CanvasRenderingContext2D | null = null;

  constructor(canvasElement: HTMLCanvasElement) {
    this.canvas = canvasElement;

    this.ctx = this.canvas?.getContext('2d');
  }

  init = () => {
    this.attachListeners();
    this.initCanvas();
  };

  initCanvas = () => {
    this.ctx?.clearRect(0, 0, window.innerWidth, window.innerHeight);

    if (this.ctx) {
      this.ctx.fillStyle = '#fff';
    }

    this.ctx?.fillRect(0, 0, window.innerWidth, window.innerHeight);
  };

  attachListeners = () => {
    this.canvas?.addEventListener('mousedown', this.startDrawing);
    this.canvas?.addEventListener('mouseup', this.stopDrawing);
    this.canvas?.addEventListener('mousemove', this.draw);
    this.canvas?.addEventListener('mouseout', this.stopDrawing);
  };

  draw = (event: MouseEvent) => {
    if (this.isDrawing) {
      const { ctx } = this;

      const newX = event.offsetX;
      const newY = event.offsetY;

      ctx?.beginPath();
      ctx?.moveTo(this.x, this.y);
      ctx?.lineTo(newX, newY);
      ctx?.stroke();

      this.x = newX;
      this.y = newY;
    }
  };

  startDrawing = (event: MouseEvent) => {
    this.isDrawing = true;
    this.x = event.offsetX;
    this.y = event.offsetY;
  };

  stopDrawing = (event: MouseEvent) => {
    this.isDrawing = false;
  };

  save = () => {
    const link = document.createElement('a');
    link.download = 'signature.png';

    const linkHref = (document.getElementById('canvas') as HTMLCanvasElement | null)?.toDataURL();
    if (linkHref) {
      link.href = linkHref;
    }

    link.click();
  };

  send = (event: any) => {
    event.preventDefault();
    this.canvas?.toBlob((blob) => {
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
}

const canvasElement = document.getElementById('canvas') as HTMLCanvasElement | null;

if (canvasElement) {
  const canvas = new Canvas(canvasElement);
  canvas.init();

  const saveBtn = document.querySelector('button#save') as HTMLButtonElement | null;
  saveBtn?.addEventListener('click', canvas.save);

  const resetBtn = document.querySelector('button#reset') as HTMLButtonElement | null;
  resetBtn?.addEventListener('click', canvas.initCanvas);

  const formElement = document.querySelector('form#signature-form') as HTMLFormElement | null;
  formElement?.addEventListener('submit', canvas.send);
}
