// ----------------
// Class LinkScroll
// ----------------
// Used to add smooth scroll on every link with href='#' attribute

export default class LinkScroll {
  constructor(target, selector, offset, delay, easing) {
    this.target = target;
    this.selector = $(selector);
    this.url = $(selector).attr('href');
    this.offset = offset;
    this.delay = delay;
    this.easing = easing;
    this.selector.on('click', (e) => {
      this.scrollIt(e);
    });
  }
  initSmoothScroll() {
    try {
      if (typeof this.url === 'undefined' || this.url === '#') {
        throw new Error('Internal URL not specified');
      } else {
        return $(this.target).animate({
          scrollTop: $(this.url).offset().top - this.offset,
        }, this.delay, this.easing);
      }
    } catch (e) {
      return console.log(e);
    }
  }
  scrollIt(e) {
    e.preventDefault();
    if (typeof this.url !== 'undefined' || this.url !== '#') {
      return this.initSmoothScroll;
    }
    return false;
  }
  static init(parameters) {
    LinkScroll.instances = [];
    $(parameters.selector).each(() => {
      LinkScroll.instances.push(
        new LinkScroll(
          parameters.target,
          this,
          parameters.offset,
          parameters.delay,
          parameters.easing,
        ),
      );
    });
  }
  static allInstances() {
    return LinkScroll.instances;
  }
}
