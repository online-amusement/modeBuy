<template>
    <div class="container">
        <form method="POST" action="/member/save">
            <input type="hidden" name="_token" v-model="csrf">
            <h1 v-if="member" class="member-title">メンバー編集</h1>
            <h1 v-else class="member-title">メンバー作成</h1>
            <div class="contents">
                <div class="member-name-contents">
                    <label class="id">メンバー管理ID：</label>
                    <input type="text" class="id" name="id" id="id" readonly v-model="id" />
                    <strong class="error" v-for="(value,index) in errors.id" :key="index">{{ value }}</strong>
                </div>
                <div class="member-name-contents">
                    <label class="name">名前：</label>
                    <input type="text" class="name" name="name" id="name" v-model="name" />
                    <strong class="error" v-for="(value,index) in errors.name" :key="index">{{ value }}</strong>
                </div>
                <div class="member-email-contents">
                    <label class="email">メールアドレス：</label>
                    <input type="text" class="email" name="email" id="email" v-model="email"/>
                    <strong class="error" v-for="(value,index) in errors.email" :key="index">{{ value }}</strong>
                </div>
                <div class="member-country-contents">
                    <label class="country">国：</label>
                    <input type="text" class="country" name="country" id="country" v-model="country" />
                    <strong class="error" v-for="(value,index) in errors.country" :key="index">{{ value }}</strong>
                </div>
                <div class="member-address-contents">
                    <label class="address">都道府県：</label>
                    <input type="text" class="address" name="address" id="address" v-model="address" />
                    <strong class="error" v-for="(value,index) in errors.address" :key="index">{{ value }}</strong>
                </div>
                <div class="member-city-contents">
                    <label class="city">都道府県2：</label>
                    <input type="text" class="city" name="city" id="city" v-model="city" />
                    <strong class="error" v-for="(value,index) in errors.city" :key="index">{{ value }}</strong>
                </div>
                <div class="member-status-contents">
                    <label class="status">ステータス：</label>
                    <input type="text" class="status" name="status" id="status" v-model="status" />
                    <strong class="error" v-for="(value,index) in errors.status" :key="index">{{ value }}</strong>
                </div>
                <div class="member-points-contents">
                    <label class="points">ポイント：</label>
                    <input type="text" class="points" name="points" v-model="points" />
                    <strong class="error" v-for="(value,index) in errors.points" :key="index">{{ value }}</strong>
                </div>
            </div>
            <div class="button">
                <button v-if="member" type="submit" class="btn">登録</button>
                <button v-else type="submit" class="btn">作成</button>
            </div>
        </form>
    </div>
</template>
<script lang="ts" setup>
import { onMounted, ref, computed } from 'vue';
const csrf = computed(() => document.querySelector('meta[name="csrf-token"]')!.getAttribute('content')) 
const props = defineProps(['member', 'input', 'errors'])
const member = props.member
const input = props.input
const id = ref(null)
const name = ref(null)
const email = ref(null)
const country = ref(null)
const address = ref(null)
const city = ref(null)
const status = ref(null)
const points = ref(null)

const isEmpty = (obj) => {
    for(let i in obj) {
        return false;
    }
    return true
}

onMounted(() => {
    console.log(member)
    setValidation();
    
})

const setValidation = () => {
    if(!isEmpty(input)) {
        id.value = input.id
        name.value = input.name
        email.value = input.email
        country.value = input.country
        address.value = input.address
        city.value = input.city
        status.value = input.status
        points.value = input.points
    }else {
        if(!isEmpty(member)) {
            id.value = member.id
            name.value = member.name
            email.value = member.email
            country.value = member.country
            address.value = member.address
            city.value = member.city
            status.value = member.status
            points.value = member.points
        }
    }
    console.log("test12",input)
    console.log("test34",member)
}

</script>
<style lang="scss" scoped>
input {
    width: 400px;
    height: 35px;
}
label {
    display: inline-block;
    width: 100px;
    vertical-align: top;
}
.container {
    max-width: 1200px;
}
.member-title {
    display: flex;
    justify-content: center;
    margin-bottom: 50px;
}
.member-name-contents {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}
.member-email-contents {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}
.member-country-contents {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}
.member-address-contents {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}
.member-city-contents {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}
.member-status-contents {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}
.member-points-contents {
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
</style>