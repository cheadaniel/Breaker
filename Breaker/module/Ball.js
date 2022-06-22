class Ball {
    constructor(x, y, radius, speed, dx, dy, fillColor, strokeColor, ctx) {
        this.x = x;
        this.y = y;
        this.radius = radius;
        this.speed = speed;
        this.dx = dx;
        this.dy = dy;
        this.fillColor = fillColor;
        this.strokeColor = strokeColor;
        this.ctx = ctx;
    }

    drawBall() {
        this.ctx.beginPath();

        this.ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
        this.ctx.fillStyle = this.fillColor;
        this.ctx.fill();

        this.ctx.strokeStyle = this.strokeColor;
        this.ctx.stroke();

        this.ctx.closePath();
    }

    /*********************** BALL MOVEMENT ************************/

    moveBall() {
        this.x += this.dx;
        this.y += this.dy;
    }
}

export default Ball;