<template>
    <div>
        <label v-if="label" class="block mb-1 font-medium">{{ label }}</label>
        <div ref="editorContainer"></div>
        <p v-if="error" class="text-red-500 text-sm mt-1">{{ error }}</p>
    </div>
</template>

<script setup>
import { defineProps, defineEmits, ref, onMounted, onBeforeUnmount, watch } from "vue";
import Quill from "quill";
import "quill/dist/quill.snow.css";

const props = defineProps({
    modelValue: {
        type: [String, Object],
        default: ''
    },
    label: String,
    error: String
});

const emit = defineEmits(["update:modelValue"]);
const editorContainer = ref(null);
const editor = ref(null);
const isContentSetProgrammatically = ref(false);

onMounted(() => {
    editor.value = new Quill(editorContainer.value, {
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline', 'strike'],
                ['blockquote', 'code-block'],
                [{ 'header': 1 }, { 'header': 2 }],
                [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                // ['link', 'image'],
                ['clean']
            ]
        },
        placeholder: 'Start writing...'
    });

    if (props.modelValue) {
        isContentSetProgrammatically.value = true;
        setEditorContent(props.modelValue);
        isContentSetProgrammatically.value = false;
    }
    editor.value.on('text-change', () => {
        if (!isContentSetProgrammatically.value) {
            const htmlContent = editor.value.root.innerHTML;
            emit('update:modelValue', htmlContent);
        }
    });
});

watch(() => props.modelValue, (newValue) => {
    if (editor.value && getEditorContent() !== newValue) {
        isContentSetProgrammatically.value = true;
        setEditorContent(newValue);
        isContentSetProgrammatically.value = false;
    }
});

const setEditorContent = (content) => {
    if (typeof content === 'string') {
        editor.value.root.innerHTML = content;
    } else if (content && typeof content === 'object') {
        try {
            editor.value.setContents(content);
        } catch (error) {
            console.error('Failed to set Delta content:', error);
            editor.value.setText('');
        }
    } else {
        editor.value.setText('');
    }
};

const getEditorContent = () => {
    return editor.value ? editor.value.root.innerHTML : '';
};

onBeforeUnmount(() => {
    if (editor.value) {
        editor.value.off('text-change');
    }
});
</script>

<style scoped>
div[ref="editorContainer"] {
    min-height: 200px;
}
</style>
