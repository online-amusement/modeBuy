<template>
    <div class="container">
        <span v-text="objectLineup.preview_file"></span>
        <ObjPreview 
            :preview-file="objectLineup.preview_file" 
            :preview-option="previewOption"
            v-if="objectLineup.preview_file.indexOf('obj') > -1"/>
        <GLTFPreview :preview-file="objectLineup.preview_file" v-if="objectLineup.preview_file.indexOf('gltf') > -1"/>
        <FBXPreview :preview-file="objectLineup.preview_file" v-if="objectLineup.preview_file.indexOf('fbx') > -1"/>

        <button v-on:click="downloadCanvas">download</button>
        <input type="text" v-model="imageData" />
    </div>
</template>
<script lang="ts" setup>
import { Value } from 'sass';
import { onMounted, ref, computed } from 'vue';
import ObjPreview from '../three/ObjPreview.vue';
import GLTFPreview from '../three/GLTFPreview.vue';
import FBXPreview from '../three/FBXPreview.vue';

const props = defineProps(['objectLineup', 'tagCategories', 'softwareCategories', 'input', 'errors'])

const objectLineup = props.objectLineup

const imageData = ref("")

const previewOption = {
    //x:11.576136204636821, y: 11.576136204636823, z: 11.576136204636823
    x: 25.767157507746774, y: -80.04750392797474, z: 26.45072706141017
}


onMounted(() => {
   
})

const downloadCanvas = () => {
    const canvas = document.querySelector("canvas") as HTMLCanvasElement;

    imageData.value = canvas.toDataURL("image/png")

    // let link = document.createElement("a");
    // link.href = canvas.toDataURL("image/png");
    // link.download = "test.png";
    // link.click();
}

</script>
<style lang="scss" scoped>
.id {
    width: 600px;
    height: 35px;
}
.name {
    width: 600px;
    height: 35px;
}
.description {
    width: 600px;
    height: 35px;
}
.amount {
    width: 600px;
    height: 35px;
}
.categories {
    width: 20px;
    height: 20px;
}
.softwareCategorey {
    width: 20px;
    height: 20px;
}
.previewFile {
    width: 600px;
    height: 35px;
}
.downloadFile {
    width: 600px;
    height: 35px;
}
.selectTagCategory {
    width: 600px;
    height: 35px;
}
.selectSoftwareCategory {
    width: 600px;
    height: 35px;
}
.tag-categories {
    width: 90px;
    display: grid;
    justify-content: center;
}
.software-categories {
    width: 100px;
    display: grid;
    justify-content: center;
}
.container {
    max-width: 1200px;
}
.object-lineup-title {
    display: flex;
    justify-content: center;
    margin-bottom: 50px;
}
.object-lineup-id-contents {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}
.object-lineup-name-contents {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}
.object-lineup-description-contents {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}
.object-lineup-amount-contents {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}
.object-lineup-preview-file-contents {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}
.object-lineup-download-file-contents {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}
.object-lineup-tool-id-contents {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}
.object-lineup-software-id-contents {
    display: flex;
    justify-content: center;
    margin-bottom: 50px;
}
.button {
    display: flex;
    justify-content: center;
}
.btn {
    width: 350px;
    height: 35px;
    background: #0000BB;
    color: #fff;
    border: none;
    border-radius: 5px;
}
.image-preview {
    display: flex;
    justify-content: center;
}
</style>