
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

const cloneOf = (obj) => {
    return JSON.parse(JSON.stringify(obj));
}

const b64toBlob = async (b64Data) => {
    const url = b64Data;
    console.log("b64Data :",b64Data);
    const response = await fetch(url);
    const blob = await response.blob();
    console.log("blob :",blob);
    return blob;
};

const defaultForm = {
    name      : '',
    department: '',
};

const defaultFormError = {
    name      : false,
    department: false,
};

const initData = {
    form         : cloneOf(defaultForm),
    formError    : cloneOf(defaultFormError),
    getNumber_ing: false,
    submitting   : false,
    number       : '',
    step         : 1,
    imageUrl     : '',
    resultImage  : '',
    showResult   : false,
    showPreview  : false,
    text_fontSize: '80px',
    huodongItem  : null,
    textNoBorder : false,
};

const app = new Vue({
    el      : '#app',
    data    : cloneOf(initData),
    mounted() {
        // this.makePreview();
    },
    computed: {
        scaleElement() {
            return this.$refs[ 'scaleElement' ];
        },
        uploadInputElement() {
            return this.$refs[ 'uploadInput' ];
        },
        containerElement() {
            return this.$refs[ 'container' ];
        }
    },
    methods : {
        readUrl(input) {
            if (input.files && input.files[ 0 ]) {
                var reader = new FileReader();

                reader.onload = (e) => {
                    this.imageUrl = e.target.result;
                    this.step     = 3;
                };

                reader.readAsDataURL(input.files[ 0 ]);
            }
        },
        handleUploadBtn(evt) {
            this.uploadInputElement.click();
        },
        handleFileInputChange(evt) {
            this.readUrl(evt.target);
            console.log("evt :", evt);
        },
        resetField() {
            this.form = cloneOf(defaultForm);
        },
        resetError() {
            this.formError = cloneOf(defaultFormError);
        },
        validationForm() {
            console.log("this.form :", this.form);
            if (!this.form.name) this.formError.name = true;
            if (!this.form.department) this.formError.department = true;
            return this.formError.name || this.formError.department;
        },
        dragMoveListener(event) {
            let target = event.target;
            // keep the dragged position in the data-x/data-y attributes
            let x      = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx;
            let y      = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

            // translate the element
            target.style.webkitTransform =
                target.style.transform =
                    'translate(' + x + 'px, ' + y + 'px)';

            // update the position attributes
            target.setAttribute('data-x', x);
            target.setAttribute('data-y', y);
        },
        convert2canvas(element) {

            return new Promise((resolve, reject) => {
                var shareContent = element;
                var width        = shareContent.offsetWidth;
                var height       = shareContent.offsetHeight;
                var canvas       = document.createElement("canvas");
                var scale        = 2;
                canvas.width     = width * scale;
                canvas.height    = height * scale;
                canvas.getContext("2d").scale(scale, scale);
                var opts = {
                    scale  : scale,
                    canvas : canvas,
                    logging: true,
                    width  : width,
                    height : height,
                    useCORS: true,
                };

                html2canvas(shareContent).then(function (canvas) {


                    // var ctx                         = canvas.getContext('2d');
                    // ctx.webkitImageSmoothingEnabled = true;
                    // ctx.mozImageSmoothingEnabled    = true;
                    // ctx.imageSmoothingEnabled       = true;
                    // var img                         = canvas.toDataURL('image/png');


                    var context                         = canvas.getContext('2d');
                    // 【重要】关闭抗锯齿
                    context.mozImageSmoothingEnabled    = false;
                    context.webkitImageSmoothingEnabled = false;
                    context.msImageSmoothingEnabled     = false;
                    context.imageSmoothingEnabled       = false;

                    // 【重要】默认转化的格式为png,也可设置为其他格式
                    var img = Canvas2Image.convertToJPEG(canvas, canvas.width, canvas.height);
                    resolve(img.src);
                });
            });

        },
        makePhoto() {
            this.textNoBorder = true;
            this.containerElement.scrollTop = 0;
            this.$nextTick(async () => {
                console.log("this.$refs['preview'] :", this.$refs[ 'previewImage' ]);
                let img = await this.convert2canvas(this.$refs[ 'preview' ]);

                this.initResult(img);
                this.textNoBorder = false;
                this.showPreview  = false;
            })
        },
        reset() {
              this.resetField();
              this.resetError();
              this.step = 1;
              this.showPreview = false;
              this.showResult = false;
              this.imageUrl = '';
              this.number = '';

        },
        async submitImage(image = this.resultImage , id = this.huodongItem.id ) {

            let blob = await b64toBlob(image);
            let data = new FormData();
            data.append('image', blob);
            let res = await axios.post(`/api/huodong/image/${id}` , data);

            console.log("rse :",res);
            console.log("this.blob :",blob);
        },
        initResult(img) {
            if (!img) {
                swal({
                    title: 'Error!',
                    content: 'Empty Image. Call Administrator!',
                    icon : 'error'
                });
                return;
            }
            this.resultImage = img;
            this.showResult   = true;
            this.submitImage();
        },
        setFontSize(width) {
            this.text_fontSize = Math.floor(width / 2.6) + 'px';
        },
        initTnteract() {
            interact('.preview-text')
                .draggable({
                    // enable inertial throwing
                    inertia   : true,
                    // keep the element within the area of it's parent
                    modifiers : [
                        interact.modifiers.restrictRect({
                            restriction: 'parent',
                            endOnly    : true
                        })
                    ],
                    // enable autoScroll
                    autoScroll: true,

                    // call this function on every dragmove event
                    onmove: this.dragMoveListener,
                })
                .resizable({
                    // resize from all edges and corners
                    edges: { left: true, right: true },

                    modifiers: [
                        // keep the edges inside the parent
                        interact.modifiers.restrictEdges({
                            outer  : 'parent',
                            endOnly: true
                        }),

                        // minimum size
                        interact.modifiers.restrictSize({
                            min: { width: 50, height: 50 }
                        })
                    ],

                    inertia: true
                })
                .on('resizemove', (event) => {
                    var target = event.target;
                    var x      = (parseFloat(target.getAttribute('data-x')) || 0);
                    var y      = (parseFloat(target.getAttribute('data-y')) || 0);

                    // update the element's style
                    this.setFontSize(event.rect.width);
                    target.style.width  = event.rect.width + 'px';
                    target.style.height = event.rect.height + 'px';

                    // translate when resizing from top or left edges
                    x += event.deltaRect.left;
                    y += event.deltaRect.top;

                    target.style.webkitTransform = target.style.transform =
                        'translate(' + x + 'px,' + y + 'px)';

                    target.setAttribute('data-x', x);
                    target.setAttribute('data-y', y)
                });
        },
        makePreview() {
            this.showPreview = true;
            this.initTnteract();
        },
        async handleMakeRow(data) {
            let res          = await axios.post('/api/huodong', data);
            this.huodongItem = res.data;
        },
        handleSubmit(evt) {
            evt.preventDefault();

            if (this.submitting) return;

            if (this.validationForm()) {
                swal({
                    title: "Error!",
                    text : "Please input success data!",
                    icon : "error",
                });
                return;
            }
            this.submitting = true;

            let data    = cloneOf(this.form);
            data.number = this.number;
            this.handleMakeRow(data);
            this.makePreview();
        },
        async getNumber() {
            if (this.getNumber_ing) return;
            this.getNumber_ing = true;

            let res            = await axios.get('/api/huodong/number');
            this.number        = res.data;
            this.getNumber_ing = false;

            this.step = 2;

        }
    }
});
