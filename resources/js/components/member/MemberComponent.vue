<template>
    <div class="container">
        <h1 class="member-title">メンバー管理</h1>
        <form method="GET" action="/home">
            <div class="search-contents">
                <div class="search-area">
                    <div class="search-contents-1">
                        <div class="member-id-search">
                            <label class="id">メンバー管理番号:</label>
                            <input v-model="memberId" type="text" class="searchMemberId" name="searchMemberId" id="searchMemberId"  />
                        </div>
                        <div class="member-status-search">
                            <label class="status">メンバーステータス:</label>
                            <input v-model="status" type="text" class="searchMemberStatus" name="searchMemberStatus" id="searchMemberStatus" />
                        </div>
                    </div>
                    <div class="search-contents-2">
                        <div class="member-start-date-search">
                            <label class="start-date">開始日時:</label>
                            <input v-model="started_at" type="date" class="searchMemberStartDate" name="searchMemberStartDate" id="searchMemberStartDate" />
                        </div>
                        <p class="line-text">
                            <span class="line">〜</span>
                        </p>
                        <div class="member-end-date-search">
                            <label class="end-date">終了日時:</label>
                            <input v-model="ended_at" type="date" class="searchMemberEndDate" name="searchMemberEndDate" id="searchMemberEndDate" />
                        </div>
                    </div>
                    <div class="searchSort">
                        <label class="sort">ソート:</label>
                        <select v-model="sort" name="searchSort" id="searchSort" class="searchSort">
                            <option>昇順</option>
                            <option>降順</option>
                        </select>
                    </div>
                </div>  
                <div class="search-btn">
                    <button @click="searchMember" class="btn" type="submit">検索</button>
                </div>
                <div class="clear">
                    <button @click="clear()" class="clearBtn" type="button">クリア</button>
                </div>
                <button type="button" class="create-btn"><a class="create-color" :href="'/member/create'">作成</a></button>
                <div class="">
                    <table border="1">
                        <thead>
                            <tr>
                            <th>メンバー管理ID</th>
                            <th>名前</th>
                            <th>メールアドレス</th>
                            <th>国</th>
                            <th>住所1</th>
                            <th>住所2</th>
                            <th>ステータス</th>
                            <th>ポイント</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(member,index) in members" :key="index">
                            <td>{{member.id}}</td>
                            <td>{{member.name}}</td>
                            <td class="email">{{member.email}}</td>
                            <td>{{member.country}}</td>
                            <td>{{member.address}}</td>
                            <td>{{member.city}}</td>
                            <td>{{member.status}}</td>
                            <td>{{member.points}}</td>
                            <td class="btn-area">
                                <button type="button" class="update-btn"><a class="update-color" :href="'/member/' + member.id + '/edit' ">更新</a></button>
                                <button type="button" class="delete-btn"><a class="delete-color" :href="'/member/' + member.id + '/delete' ">削除</a></button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div v-if="props.members.data.length == 0" class="no-contents">
                    <p>検索結果が存在しません。</p>
                </div>
            </div>
        </form>
        <div class="pagenation-area">
            <div class="page" v-for="(link,index) in props.members.links" :key="index">
                <button type="submit" :disabled="link.url == null" class="link-btn" :class="{'pagination-link-enabled': link.active == true,'pagination-link-active': link.active == false}">
                    <a @click="searchMember(link.label)" :disabled="link.url == null" :href="link.url" class="link-btn">{{ link.label.replaceAll('&amp;laquo; Previous', '<<').replaceAll('Next &amp;raquo;', '>>') }}</a>
                </button>
            </div>
        </div>
    </div>
</template>
<script lang="ts" setup>
import { onMounted, ref } from 'vue';

const props = defineProps(['members', 'input'])
const members = props.members.data
const memberId = ref("");
const status = ref("");
const started_at = ref("");
const ended_at = ref("");
const labels = ref("");
const pagenate = ref([]);
const pages = ref<string[]>([]);
const searchParams = ref(new URLSearchParams(window.location.search));
const val = ref();
const page = ref('1');
const sort = ref([
    {text: "昇順", value: 'asc'},
    {text: "降順", value: 'desc'}
])

const url = location.pathname;
let beforPage = ref("");


onMounted(() => {

})

//選択されてるページネーションのボタンの色を変更
const isCurrent = ((page) => {
    let pager = props.members;
    return page === pager.current_page
})


const clear = () => {
    location.href = props.members.path
}

const searchMember = (pageNum) => {
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

</script>
<style lang="scss" scoped>
.container {
    max-width: 1200px;
}
.member-title {
    display: flex;
    justify-content: center;
    margin-bottom: 50px;
}
.search-area {
    margin-bottom: 50px;
}
.search-contents-1 {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}
.search-contents-2 {
    display: flex;
    justify-content: center;
}
.member-id-search {
    display: grid;
    margin-right: 55px;
}
.member-status-search {
    display: grid;
    margin-left: 55px;
}
.member-start-date-search {
    display: grid;
    justify-content: center;
    margin-bottom: 20px;
    margin-right: 50px;
}
.member-end-date-search {
    display: grid;
    justify-content: center;
    margin-bottom: 20px;
}
.btn {
    width: 300px;
    height: 40px;
    background: #0000BB;
    color: #fff;
}
.search-btn {
    display: flex;
    justify-content: center;
    margin-bottom: 10px;
}
.clear {
    display: flex;
    justify-content: center;
}
.clearBtn {
    width: 300px;
    height: 40px;
    background: #DD0000;
    color: #fff;
    margin-bottom: 50px;
}
.line-text {
    margin-top: 25px;
    margin-right: 50px;
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
.btn-area {
    text-align: center;
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
a.create-color[data-v-3b6dc5ca] {
    text-decoration: none;
    color: #fff;
}
a.update-color[data-v-3b6dc5ca] {
    text-decoration: none;
    color: #000;
}
a.delete-color[data-v-3b6dc5ca] {
    text-decoration: none;
    color: #fff;
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
img {
    width: 30px;
    height: 30px;
}
.no-contents {
    display: flex;
    justify-content: center;
    margin-bottom: 50px;
    font-weight: 700;
    font-size: large;
}
.searchSort {
    display: grid;
    justify-content: center;
    margin-bottom: 20px;
    margin-right: 50px;
}
select {
    width: 150px;
    height: 25px;
}
</style>