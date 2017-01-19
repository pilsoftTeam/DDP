<template>
    <div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"></div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            <el-upload
                    action="//jsonplaceholder.typicode.com/posts/"
                    type="drag"
                    :multiple="true"
                    :on-preview="handlePreview"
                    :on-remove="handleRemove"
                    :on-success="handleSuccess"
                    :on-error="handleError"
                    :default-file-list="fileList">
                <i class="el-icon-upload"></i>
                <div class="el-dragger__text">Arrastre archivos hasta aca para subir
                    <br>
                    <em>Haga click para subir archivos</em></div>
                <div class="el-upload__tip" slot="tip">-</div>
            </el-upload>


        </div>


        <el-dialog title="Tips" v-model="dialogVisible" size="small">

            <img :src="imageSelected" alt="" class="img img-responsive center-block">

            <span slot="footer" class="dialog-footer">
                <el-button type="primary" @click="dialogVisible = false">OK</el-button>
              </span>
        </el-dialog>
    </div>
</template>
<style>
    input.el-upload__input {
        display: none;
    }
</style>

<script>
    export default {
        data () {
            return {
                imageSelected: '',
                dialogVisible: false,
                fileList: [{
                    name: 'food.jpeg',
                    url: 'https://fuss10.elemecdn.com/3/63/4e7f3a15429bfda99bce42a18cdd1jpeg.jpeg?imageMogr2/thumbnail/360x360/format/webp/quality/100'
                }, {
                    name: 'food2.jpeg',
                    url: 'https://fuss10.elemecdn.com/3/63/4e7f3a15429bfda99bce42a18cdd1jpeg.jpeg?imageMogr2/thumbnail/360x360/format/webp/quality/100'
                }]

            }
        },

        methods: {
            handleRemove(file, fileList) {
                console.log(file, fileList);
            },
            handlePreview(file) {
                this.imageSelected = file.url
                this.dialogVisible = true;
            }
        }
    }
</script>
