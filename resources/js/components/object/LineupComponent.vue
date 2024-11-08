<template>
    <div class="container">
        <h1 class="object-title">オブジェクト管理</h1>
        <div class="search-form">
            <form method="GET" action="/object-lineup" class="form-area">
                <div class="search-text-inp">
                    <div class="group-form">
                        <div class="search_contents-1">
                            <div class="searchItemIdArea">
                                <label class="searchObjectId">商品Id:</label>
                                <input type="text" v-model="objectId" class="searchObjectId" name="searchObjectId" id="searchObjectId">
                            </div>
                            <div class="searchItemNameArea">
                                <label class="objectName">オブジェクト名:</label>
                                <input type="text" v-model="name" class="searchName" name="searchName" id="searchName">
                            </div>
                        </div>
                        <div class="search-contents-2">
                            <div class="object-start-date-search">
                                <label class="start-date">開始日時:</label>
                                <input v-model="started_at" type="date" class="searchObjectStartDate" name="searchObjectStartDate" id="searchObjectStartDate" />
                            </div>
                            <p class="line-text">
                                <span class="line">〜</span>
                            </p>
                            <div class="object-end-date-search">
                                <label class="end-date">終了日時:</label>
                                <input v-model="ended_at" type="date" class="searchObjectEndDate" name="searchObjectEndDate" id="searchObjectEndDate" />
                            </div>
                        </div>
                        <div class="search-contents-3">
                            <div class="searchObjectAmountArea">
                                <label class="objectAmount">金額:</label>
                                <input type="text" v-model="amount" class="searchAmount" name="searchAmount" id="searchAmount">
                            </div>
                            <div class="searchObjectSortArea">
                                <label class="sort">ソート:</label>
                                <select v-model="sort" name="searchSort" id="searchSort" class="searchSort">
                                    <option>昇順</option>
                                    <option>降順</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="search-btn">
                    <button @click="searchObject" class="btn" type="submit">検索</button>
                </div>
                <div class="clear">
                    <button @click="clear()" class="clearBtn" type="button">クリア</button>
                </div>
                <button type="button" class="create-btn"><a class="create-color" :href="'/object-lineup/create'">作成</a></button>
                <div class="">
                    <table border="1">
                        <thead>
                            <tr>
                            <th>オブジェクト管理ID</th>
                            <th>名前</th>
                            <th>詳細</th>
                            <th>金額</th>
                            <th>プレビューファイル名</th>
                            <th>ダウンロードファイル名</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(objectLineup,index) in objectLineups" :key="index">
                            <td>{{objectLineup.id}}</td>
                            <td>{{objectLineup.name}}</td>
                            <td>{{objectLineup.description}}</td>
                            <td>{{objectLineup.amount}}</td>
                            <td class="preview">{{objectLineup.preview_file}}</td>
                            <td class="download">{{objectLineup.download_file}}</td>
                            <td class="btn-area">
                                <button type="button" class="update-btn"><a class="update-color" :href="'/object-lineup/' + objectLineup.id + '/edit' ">更新</a></button>
                                <button type="button" class="delete-btn"><a class="delete-color" :href="'/object-lineup/' + objectLineup.id + '/delete' ">削除</a></button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div v-if="props.objectLineups.data.length == 0" class="no-contents">
                    <p>検索結果が存在しません。</p>
                </div>
            </form>
            <div class="pagenation-area">
                <div class="page" v-for="(link,index) in props.objectLineups.links" :key="index">
                    <button type="submit" :disabled="link.url == null" class="link-btn" :class="{'pagination-link-enabled': link.active == true,'pagination-link-active': link.active == false}">
                        <a @click="searchObject(link.label)" :disabled="link.url == null" :href="link.url" class="link-btn">{{ link.label.replaceAll('&amp;laquo; Previous', '<<').replaceAll('Next &amp;raquo;', '>>') }}</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script lang="ts" setup>
import { onMounted, ref } from 'vue';

const props = defineProps(['objectLineups', 'input'])
console.log("props.objectLineups", props)
const objectLineups = props.objectLineups.data
const objectId = ref('');
const name = ref('');
const amount = ref('');
const started_at = ref('');
const ended_at = ref('');
const sort = ref([
    {text: "昇順", value: 'asc'},
    {text: "降順", value: 'desc'}
])
const searchParams = ref(new URLSearchParams(window.location.search));
const val = ref();
const page = ref('1');


const url = location.pathname;
let beforPage = ref("");

onMounted(() => {
    console.log("objects",objectLineups.data)
})

const searchObject = (pageNum) => {
    page.value = pageNum
    console.log(searchParams.value)
    val.value = searchParams.value.get("page")
    console.log(val.value)
    if(page.value == val.value) {
        searchParams.value.set("page", page.value);
    }else {
        searchParams.value.set("page", page.value);
    }
}

const clear = () => {
    location.href = props.objectLineups.path
}


</script>
<style lang="scss" scoped>
.object-title {
    display: flex;
    justify-content: center;
    margin-bottom: 50px;
}
.searchItemIdArea {
    display: grid;
    margin-right: 55px;
}
.searchItemNameArea {
    display: grid;
    margin-left: 55px;
}
.object-start-date-search {
    display: grid;
    margin-right: 50px;
}
.object-end-date-search {
    display: grid;
    margin-left: 50px;
}
.searchObjectAmountArea {
    display: grid;
    margin-right: 55px;
}
.searchObjectSortArea {
    display: grid;
    margin-left: 55px;
}
.search_contents-1 {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}
.search-contents-2 {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}
.search-contents-3 {
    display: flex;
    justify-content: center;
    margin-bottom: 50px;
}
.btn {
    width: 300px;
    height: 40px;
    background: #0000BB;
    color: #fff;
}
.clearBtn {
    width: 300px;
    height: 40px;
    background: #DD0000;
    color: #fff;
    margin-bottom: 50px;
    border-radius: 5px;
}
.search-btn {
    display: flex;
    justify-content: center;
    margin-bottom: 5px;
}
.clear {
    display: flex;
    justify-content: center;
}
input {
    width: 200px;
    height: 35px;
}
select {
    width: 200px;
    height: 35px;
}
table {
    border: 1px solid black;
    border-collapse: collapse;
    padding: 1em;
    table-layout: fixed;
    width: 100%;
}
th {
    border: 1px solid black;
    border-collapse: collapse;
    padding: 1em;
    text-align: center;
}
td {
    border: 1px solid black;
    border-collapse: collapse;
    padding: 1em;
}
td.password {
    overflow-x: scroll;
    white-space: nowrap;
    -webkit-overflow-scrolling: touch;
}
td.email {
    overflow-x: scroll;
    white-space: nowrap;
    -webkit-overflow-scrolling: touch;
}
.pagenation-area {
    display: flex;
    justify-content: center;
    margin-top: 50px;
}
.page-btn {
    display: flex;
    justify-content: center;
    align-items: center;
    color: #fff;
    background: #808080;
    width: 50px;
    height: 50px;
}
.pagination-link-enabled {
    color: #fff;
    background:#0000BB;
    width: 50px;
    height: 50px;
    position:relative;
    transition:all .2s;
}
.pagination-link-enabled .link-btn {
    padding: 15px 0px 15px 0px;
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:100%;
    text-decoration: none;
    color: #fff;
}
.pagination-link-active{
    color: #fff;
    background: #808080;
    color:#fff;
    width: 50px;
    height: 50px;
    position:relative;
    transition:all .2s;
}
.pagination-link-active .link-btn {
    padding: 15px 0px 15px 0px;
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:100%;
    text-decoration: none;
    color: #fff;
}
.no-contents {
    display: flex;
    justify-content: center;
    margin-bottom: 50px;
    font-weight: 700;
    font-size: large;
}
.create-btn {
    margin-bottom: 5px;
    background: #0000BB;
    color: #fff;
    border: none;
    border-radius: 3px;
    width: 50px;
    height: 30px;
}
a.create-color {
    text-decoration: none;
    color: #fff;
}
p {
    margin-top: revert;
}
.update-btn {
    margin-bottom: 5px;
    background: #FFFF11;
    border: none;
    border-radius: 3px;
    width: 50px;
    height: 30px;
}
.delete-btn {
    margin-bottom: 5px;
    background: #DD0000;
    border: none;
    border-radius: 3px;
    width: 50px;
    height: 30px;
    margin: 0 5px;
}
a.update-color {
    text-decoration: none;
    color: #000;
}
a.delete-color {
    text-decoration: none;
    color: #fff;
}
.btn-area {
    text-align: center;
}
td.preview {
    overflow-x: scroll;
    white-space: nowrap;
    -webkit-overflow-scrolling: touch;
}
td.download {
    overflow-x: scroll;
    white-space: nowrap;
    -webkit-overflow-scrolling: touch;
}
</style>