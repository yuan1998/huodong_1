<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.loli.net/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <link href="https://fonts.loli.net/css?family=Press+Start+2P" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nes.css@2.2.0/css/nes.min.css">
    <link rel="stylesheet" href="{{asset('css/welcome.css')}}">
</head>
<body>
<div id="app" :style="{display:'block'}">
    <div class="container" ref="container">
        <div class="number-text nes-text" v-if="number">
            请ての文字は 7×7 ドットの範囲に収まっているため、
            Number : @{{number}}
        </div>
        <template v-if="showResult">
            <div id="result-container">
                <div class="container">
                    <div class="result-image">
                        <img :src="resultImage" alt="" class="mw-img">
                    </div>
                    <div class="close-btn">
                        <button type="button" @click="reset" class="nes-btn is-primary">X</button>
                    </div>
                </div>
            </div>
        </template>
        <template  v-else-if="showPreview">
            <div id="preview-container" ref="preview">
                <div class="preview-image" ref="previewImage">
                    <img :src="imageUrl" alt="" class="mc-img">
                </div>
                <div class="preview-text" :class="textNoBorder && 'no-border'">
                    <div id="scale-element" :style="{fontSize: text_fontSize}">
                        @{{number}}
                    </div>
                </div>

            </div>
            <div class="preview-make-btn">
                <button type="button" @click="makePhoto" class="nes-btn is-primary">Make Photo</button>

            </div>
        </template>

        <div class="pos-center" v-else>
            <div class="nes-container is-rounded center" v-if="step === 1">
                <button @click="getNumber" type="button" :class="'is-disabled' && getNumber_ing" class="nes-btn is-success">Get numbers</button>
            </div>
            <div class="nes-container is-rounded" v-else-if="step === 2">
                <div class="center ">
                    <div class="upload-input" style="display: none;">
                        <input type="file" @change="handleFileInputChange" ref="uploadInput" >
                    </div>
                    <div class="upload-btn" @click="handleUploadBtn">
                        <svg t="1564415653287" class="icon" viewBox="0 0 1024 1024" version="1.1"
                             xmlns="http://www.w3.org/2000/svg" p-id="3242" width="200" height="200">
                            <path
                                d="M210.71872 675.75808a20.48 20.48 0 0 0-20.48 20.48v125.60384a20.48 20.48 0 0 0 20.48 20.48h573.44a20.48 20.48 0 0 0 20.48-20.48v-125.60384a20.48 20.48 0 1 0-40.96 0v105.12384h-532.48v-105.12384a20.48 20.48 0 0 0-20.48-20.48z"
                                fill="#212529" p-id="3243"></path>
                            <path
                                d="M498.33984 716.71808a20.48 20.48 0 0 0 20.48-20.48v-440.5248l129.90464 125.48096a20.39808 20.39808 0 0 0 28.93824-0.49152 20.48 20.48 0 0 0-0.49152-28.95872l-164.31104-158.74048-0.04096-0.04096-0.26624-0.24576c-0.73728-0.7168-1.65888-1.024-2.4576-1.59744-1.31072-0.94208-2.51904-1.98656-4.01408-2.60096a20.41856 20.41856 0 0 0-7.31136-1.47456c-0.14336 0-0.28672-0.08192-0.43008-0.08192s-0.28672 0.08192-0.43008 0.08192a20.50048 20.50048 0 0 0-7.31136 1.47456c-1.49504 0.6144-2.70336 1.65888-4.01408 2.58048-0.79872 0.59392-1.72032 0.90112-2.4576 1.61792l-0.24576 0.22528-0.04096 0.04096-164.31104 158.74048a20.48 20.48 0 0 0 28.44672 29.45024l129.90464-125.48096v440.5248a20.43904 20.43904 0 0 0 20.45952 20.50048z"
                                fill="#212529" p-id="3244"></path>
                        </svg>
                        <div class="title ">Upload image</div>
                    </div>
                </div>
            </div>
            <form class="nes-container with-title is-centered nes-text form-el " v-else-if="step === 3" @submit="handleSubmit">
                <div class="title">Form data</div>
                <div class="nes-field">
                    <label for="name_field">Your name</label>
                    <input type="text" class="nes-input" v-model="form.name" placeholder="请输入姓名">
                </div>
                <div class="nes-field">
                    <label for="name_field">Your department</label>
                    <input type="text" class="nes-input" v-model="form.department" placeholder="请输入部门">
                </div>
                <div class="form-control center">
                    <button type="submit" class="nes-btn is-primary">Submit</button>
                    <a class="nes-btn">Reset</a>
                </div>
            </form>

        </div>


    </div>


</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios@0.19.0/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.0.0-rc.3/dist/html2canvas.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/interactjs@1.5.4/dist/interact.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert@2.1.2/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/canvas2image@1.0.5/canvas2image.min.js"></script>
<script type="text/javascript" src="{{ asset('js/welcome.js') }}"></script>

</html>
