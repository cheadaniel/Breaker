class Paddle {
    constructor(x, y, width, height, dx, fillColor, strokeColor, ctx) {
        this.x = x;
        this.y = y;
        this.width = width;
        this.height = height;
        this.dx = dx;
        this.fillColor = fillColor;
        this.strokeColor = strokeColor;
        this.ctx = ctx;
    }

    drawPaddle() {
        this.ctx.fillStyle = this.fillColor;
        this.ctx.fillRect(this.x, this.y, this.width, this.height);

        this.ctx.strokeStyle = this.strokeColor;
        this.ctx.strokeRect(this.x, this.y, this.width, this.height);
    }

}

export default Paddle;