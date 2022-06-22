class Brick {
  constructor(
    row,
    column,
    width,
    height,
    offSetLeft,
    offSetTop,
    topMargin,
    fillColor,
    strokeColor
  ) {
    this.row = row;
    this.column = column;
    this.width = width;
    this.height = height;
    this.offSetLeft = offSetLeft;
    this.offSetTop = offSetTop;
    this.topMargin = topMargin;
    this.fillColor = fillColor;
    this.strokeColor = strokeColor;
  }
}

export default Brick;
