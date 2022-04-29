export default function() {
  function Editable(sel, options, isRich) {
    // eslint-disable-next-line prefer-rest-params
    if (!(this instanceof Editable)) return new Editable(...arguments);

    const attr = (EL, obj) =>
      Object.entries(obj).forEach(([prop, val]) => EL.setAttribute(prop, val));

    if (isRich) {
      document.querySelectorAll(sel).forEach(el => {
        // eslint-disable-next-line no-undef
        BalloonEditor.create(el);
      });
    }

    Object.assign(
      this,
      {
        onStart() {},
        onInput() {},
        onEnd() {},
        classEditing: 'is-editing', // added onStart
        classModified: 'is-modified', // added onEnd if content changed
      },
      options || {},
      {
        elements: document.querySelectorAll(sel),
        element: null, // the latest edited Element
        isModified: false, // true if onEnd the HTML content has changed
      },
    );

    const start = ev => {
      this.isModified = false;
      this.element = ev.currentTarget;
      this.element.classList.add(this.classEditing);
      this.html_before = ev.currentTarget.innerHTML;
      this.onStart.call(this.element, ev, this);
    };

    const input = ev => {
      this.html = this.element.innerHTML;
      this.element = ev.currentTarget;
      this.isModified = this.html !== this.html_before;
      this.element.classList.toggle(this.classModified, this.isModified);
      this.onInput.call(this.element, ev, this);
    };

    const end = ev => {
      this.element = ev.currentTarget;
      this.isModified = this.element.innerHTML !== this.html_before;
      if (this.html !== this.html_before) {
        this.element.classList.toggle(this.classModified, this.isModified);
      }
      this.element.classList.remove(this.classEditing);
      this.onEnd.call(this.element, ev, this);
    };

    this.elements.forEach(el => {
      attr(el, { tabindex: 1, contenteditable: true });
      el.addEventListener('focusin', start);
      el.addEventListener('change', input);
      el.addEventListener('focusout', end);
    });

    return this;
  }

  Editable('.editable', {
    onEnd(ev, UI) {
      // ev=Event UI=Editable this=HTMLElement
      if (!UI.isModified) return; // No change in content. Abort here.
      const data = {
        tid: this.dataset.tid,
        tlang: this.dataset.tlang,
        ttype: this.dataset.ttype,
        text: this.innerHTML, // or you can also use UI.text
      };
      // eslint-disable-next-line camelcase,no-undef
      const url = `${base_url}/api/inline-editing/store`;
      const opts = {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify(data),
      };

      fetch(url, opts);
    },
  });

  Editable(
    '.rich-editable',
    {
      onEnd(ev, UI) {
        // ev=Event UI=Editable this=HTMLElement
        if (!UI.isModified) return; // No change in content. Abort here.
        const data = {
          tid: this.dataset.tid,
          tlang: this.dataset.tlang,
          ttype: this.dataset.ttype,
          text: this.innerHTML, // or you can also use UI.text
        };
        // eslint-disable-next-line camelcase,no-undef
        const url = `${base_url}/api/inline-editing/store`;
        const opts = {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          },
          body: JSON.stringify(data),
        };

        fetch(url, opts);
      },
    },
    true,
  );
}
