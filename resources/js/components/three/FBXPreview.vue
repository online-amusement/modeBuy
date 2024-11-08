<template>
    <p v-on:click="onClickDebug">{{ props.previewFile }}</p>
	<div ref="container"><!-- ここにthreeで描画を行う --></div>
</template>

<script lang="ts" setup>
import { onMounted, ref } from "vue";
import * as THREE from "three";
import { OrbitControls } from 'three/examples/jsm/controls/OrbitControls.js';
import { FBXLoader } from 'three/addons/loaders/FBXLoader.js';
import { MTLLoader } from 'three/addons/loaders/MTLLoader.js';

const props = defineProps(['previewFile', 'previewOption'])
const container = ref<HTMLDivElement>()

//ThreeJSで使うオブジェクト
const scene = new THREE.Scene();
let camera : THREE.Camera | null = null;
let renderer : THREE.WebGLRenderer | null = null;
let model : THREE.Group | null = null;
let controls: OrbitControls;

const onClickDebug = () => {
	//console.log(controls);
	console.log("camera", camera?.position);
}

const init = async () => {
	console.log("init THREE")
	console.log(container)

	scene.background = new THREE.Color('#BBFFFF');

	const w = 590;
	const h = 480;
	
	// rendererの初期化
	renderer = new THREE.WebGLRenderer({
        preserveDrawingBuffer: true
    })
	renderer.setSize(w, h)
	renderer.setPixelRatio(w / h)
	container.value?.appendChild(renderer.domElement)

	// カメラ作成
	camera = new THREE.PerspectiveCamera(45, w / h)
	if(props.previewOption){
		camera.position.set(props.previewOption.x, props.previewOption.y, props.previewOption.z)
	}else{
		camera.position.set(20, 20, 20)
	}
	camera.lookAt(new THREE.Vector3(0, 0, 0))

	// ライトの表示
	//const light = new THREE.AmbientLight(0xffffff, 4);
    const light = new THREE.PointLight(0xFFFFFF, 50, 50, 1.0);
	scene.add(light)

	// マウスでカメラを回転出来るように
	controls = new OrbitControls(camera, renderer.domElement);
	controls.enableRotate = true;

	//3Dオブジェクトの読み込み
	const loader = new FBXLoader();
	const fbx = await loader.loadAsync(props.previewFile);

    const material = new THREE.MeshNormalMaterial();

    //console.log(obj);

    fbx.traverse((child) => {
        if ( child instanceof THREE.Mesh ) {
            console.log("child", child)
            child.material = material;
        }
    })
	
	// 3Dデータの取得
	model = fbx;
	scene.add(model);

	//いい感じの大きさに調節
	model.scale.set(0.1, 0.1, 0.1);

	onDataLoaded()
	
}

//データの読み込み完了
const onDataLoaded = () => {

	tick();
}

// 毎フレーム時に実行されるループイベント
const tick = () => {

	//回転アニメーション
	if(model){
		//model.rotation.x += .01;
		//model.rotation.y += .01;
	}
	
	if(camera)renderer?.render(scene, camera)
	requestAnimationFrame(tick)
}

//表示後にinitを呼び出す
onMounted(() => {
	console.log(props.previewFile)
	init()
})
</script>