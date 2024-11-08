<template>
    <div class="container">
        <form method="POST" action="/object-lineup/save" enctype="multipart/form-data">
            <input type="hidden" name="_token" v-model="csrf">
            <h1 v-if="objectLineup" class="object-lineup-title">オブジェクト編集</h1>
            <h1 v-else class="object-lineup-title">オブジェクト作成</h1>
            <div class="contents">
                <div class="object-lineup-id-contents">
                    <label class="id">オブジェクト管理ID：</label>
                    <input type="text" class="id" name="id" id="id" readonly v-model="id" />
                    <strong class="error" v-for="(value,index) in errors.id" :key="index">{{ value }}</strong>
                </div>
                <div class="object-lineup-name-contents">
                    <label class="name">オブジェクト名：</label>
                    <input type="text" class="name" name="name" id="name" v-model="name" />
                    <strong class="error" v-for="(value,index) in errors.name" :key="index">{{ value }}</strong>
                </div>
                <div class="object-lineup-description-contents">
                    <label class="description">詳細：</label>
                    <textarea rows="10" cols="50" type="text" class="description" name="description" id="description" v-model="description"></textarea>
                    <strong class="error" v-for="(value,index) in errors.description" :key="index">{{ value }}</strong>
                </div>
                <div class="object-lineup-amount-contents">
                    <label class="amount">金額：</label>
                    <input type="text" class="amount" name="amount" id="amount" v-model="amount"/>
                    <strong class="error" v-for="(value,index) in errors.amount" :key="index">{{ value }}</strong>
                </div>
                <div class="object-lineup-preview-file-contents">
                    <label class="previewFile">プレビューファイル：</label>
                    <input type="file" class="previewFile" name="previewFile" id="previewFile" />
                    <strong class="error" v-for="(value,index) in errors.previewFile" :key="index">{{ value }}</strong>
                </div>
                <div class="obj-pre">
                    <FBXPreview 
                    :preview-file="objectLineup.preview_file" 
                    v-if="objectLineup?.preview_file.indexOf('fbx') > -1"/>
                </div>
                <div class="object-lineup-download-file-contents">
                    <label class="downloadFile">ダウンロードファイル：</label>
                    <input type="file" class="downloadFile" name="downloadFile" id="downloadFile" />
                    <strong class="error" v-for="(value,index) in errors.downloadFile" :key="index">{{ value }}</strong>
                </div>
                <div class="object-lineup-tool-id-contents">
                    <label class="selectTagCategory">オブジェクトタグID：</label>
                    <div class="tag-categories" v-for="(tag, index) in tagCategories" :key="index">
                        <input type="checkbox" class="categories" :name="'tagChains[]'" id="tagChains[]" :value="tag.id"  v-model="tagChains" />
                        <label class="labels">{{ tag.name }}</label>
                    </div>
                </div>
                <div class="object-lineup-software-id-contents">
                    <label class="selectSoftwareCategory">ソフトウェアID：</label>
                    <div class="software-categories" v-for="(software, index) in softwareCategories" :key="index">
                        <input type="checkbox" class="softwareCategorey" name="softwareChains[]" id="softwareChains[]" :value="software.id"  v-model="softwareChains" />
                        <label class="labels">{{ software.name }}</label>
                    </div>
                </div>
            </div>
            <div class="button">
                <button v-if="objectLineup" type="submit" class="btn">登録</button>
                <button v-else type="submit" class="btn">作成</button>
            </div>
        </form>
    </div>
</template>
<script lang="ts" setup>
import { Value } from 'sass';
import { onMounted, ref, computed } from 'vue';
import FBXPreview from '../three/FBXPreview.vue';
const csrf = computed(() => document.querySelector('meta[name="csrf-token"]')!.getAttribute('content')) 
const props = defineProps(['objectLineup', 'tagCategories', 'softwareCategories', 'objectLineupTag', 'objectLineupSoftware', 'input', 'errors'])
const input = props.input
const objectLineup = props.objectLineup
const tagCategories = props.tagCategories
const softwareCategories = props.softwareCategories
const objectLineupTag = props.objectLineupTag
const objectLineupSoftware = props.objectLineupSoftware
const id = ref(null)
const name = ref(null)
const description = ref(null)
const amount = ref(null)
const previewFile = ref(null)
const downloadFile = ref(null)
const tagId = ref(null)
const softwareId = ref(null)
const tagChains = ref([]);
const softwareChains = ref([]);
console.log("props", props)

const isEmpty = (obj) => {
    for(let i in obj) {
        return false;
    }
    return true
}

onMounted(() => {
    setValidation();
    if(objectLineupTag) {
        for(let i = 0; i < objectLineupTag.length; i++) {
            tagChains.value.push(objectLineupTag[i].tag_id)
            console.log(tagChains)
        }
    }

    if(objectLineupSoftware) {
        for(let j = 0; j < objectLineupSoftware.length; j++) {
            softwareChains.value.push(objectLineupSoftware[j].software_id)
            console.log(softwareChains);
        }
    }
})

const setValidation = () => {
    if(!isEmpty(input)) {
        id.value = input.id
        name.value = input.name
        description.value = input.description
        amount.value = input.amount
        previewFile.value = input.preview_file
        downloadFile.value = input.download_file
        tagId.value = input.tagId
        softwareId.value = input.softwareId
    }else {
        if(!isEmpty(objectLineup)) {
            id.value = objectLineup.id
            name.value = objectLineup.name
            description.value = objectLineup.description
            amount.value = objectLineup.amount
            previewFile.value = objectLineup.preview_file
            downloadFile.value = objectLineup.download_file
            tagId.value = objectLineup.tag_id
            softwareId.value = objectLineup.software_id
        }
    }
    console.log("test12",input)
    console.log("test34",objectLineup)
    console.log("objectlineupTag", objectLineupTag)
    console.log("objectlineupSoftware", objectLineupSoftware)
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
}
.amount {
    width: 600px;
    height: 35px;
}
.softwareCategorey {
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
    height: 50px;
    display: grid;
    justify-content: center;
}
.software-categories {
    width: 100px;
    height: 50px;
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
.obj-pre {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}
</style>