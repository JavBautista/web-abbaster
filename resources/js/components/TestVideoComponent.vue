<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Test Video Component</div>

                    <div class="card-body">
                       <template>
                            <div>
                                <input type="file" ref="fileInput" @change="uploadVideo">
                                <button @click="submit">Subir Archivo</button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
         methods: {
            uploadVideo() {
                const file = this.$refs.fileInput.files[0];
                this.video = file;
            },
            submit() {
                const formData = new FormData();
                formData.append('video', this.video);

                axios.post('/upload-testvideo', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(response => {
                    console.log('Video uploaded successfully.');
                })
                .catch(error => {
                    console.error('Error uploading video:', error);
                });
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
