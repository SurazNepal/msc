
<div class="p-5 border border-gray-200 rounded-xl shadow-lg bg-white transition duration-300 ease-in-out">
    {{-- Toolbar --}}
    <div id="editor-toolbar" class="mb-4 flex flex-wrap gap-2 border-b border-gray-100 pb-3">

        {{-- Toolbar Buttons --}}
        <button type="button" data-cmd="bold" title="Bold"
            class="toolbar-btn px-4 py-2 text-sm border-2 border-gray-300 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 font-extrabold transition duration-150">
            B
        </button>

        <button type="button" data-cmd="italic" title="Italic"
            class="toolbar-btn px-4 py-2 text-sm border-2 border-gray-300 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 italic transition duration-150">
            I
        </button>

        <button type="button" data-cmd="underline" title="Underline"
            class="toolbar-btn px-4 py-2 text-sm border-2 border-gray-300 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 underline transition duration-150">
            U
        </button>

        <button type="button" data-cmd="insertOrderedList" title="Numbered List"
            class="toolbar-btn px-4 py-2 text-sm border-2 border-gray-300 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 transition duration-150">
            OL
        </button>

        <button type="button" data-cmd="insertUnorderedList" title="Bulleted List"
            class="toolbar-btn px-4 py-2 text-sm border-2 border-gray-300 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 transition duration-150">
            UL
        </button>

        {{-- Heading Buttons --}}
        <button type="button" data-tag="H1" onclick="execBlockCommand(this.dataset.tag)" title="Heading 1"
            class="toolbar-btn block-btn px-4 py-2 text-sm border-2 border-gray-300 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold transition duration-150">
            H1
        </button>

        <button type="button" data-tag="H2" onclick="execBlockCommand(this.dataset.tag)" title="Heading 2"
            class="toolbar-btn block-btn px-4 py-2 text-sm border-2 border-gray-300 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold transition duration-150">
            H2
        </button>

        <button type="button" data-tag="H3" onclick="execBlockCommand(this.dataset.tag)" title="Heading 3"
            class="toolbar-btn block-btn px-4 py-2 text-sm border-2 border-gray-300 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold transition duration-150">
            H3
        </button>

        {{-- Link Button --}}
        <button type="button" onclick="execCmd('createLink', prompt('Enter URL:'))" title="Insert Link"
            class="px-4 py-2 text-sm border-2 border-pink-400 rounded-lg bg-pink-50 hover:bg-pink-100 text-pink-600 transition duration-150 font-medium">
            Link
        </button>
    </div>

    {{-- Editable Area (Added targeted CSS nested configurations below) --}}
    <div contenteditable="true"
        class="editor w-full min-h-[400px] border border-gray-300 rounded-lg p-4 bg-gray-50 text-gray-800
               prose prose-sm max-w-none focus:outline-none focus:ring-4 focus:ring-pink-200 focus:border-pink-400
               transition duration-150 shadow-inner
               [&_ul]:list-disc [&_ul]:pl-8 [&_ul]:my-2
               [&_ol]:list-decimal [&_ol]:pl-8 [&_ol]:my-2
               [&_li]:mb-1"
        oninput="this.nextElementSibling.value=this.innerHTML; this.nextElementSibling.dispatchEvent(new Event('input'))">
        {!! $slot !!}
    </div>

    {{-- Hidden input for Livewire binding --}}
    <textarea class="hidden" {{ $attributes->whereStartsWith('wire:model') }}>
        {!! $slot !!}
    </textarea>
</div>

<script>
    let currentEditor = null;
    let savedSelection = null;

    const HEADING_CLASSES = {
        'H1': 'text-4xl font-extrabold mt-8 mb-4',
        'H2': 'text-3xl font-bold mt-6 mb-3',
        'H3': 'text-2xl font-semibold mt-4 mb-2',
        'P': ''
    };

    document.addEventListener("DOMContentLoaded", () => {
        const editors = document.querySelectorAll(".editor");
        const toolbar = document.getElementById("editor-toolbar");

        toolbar.querySelectorAll(".toolbar-btn").forEach(btn => {
            btn.addEventListener("click", () => {
                const cmd = btn.dataset.cmd;
                const val = btn.dataset.val;
                if (cmd) {
                    execCmd(cmd, val);
                }
                updateToolbarState();
            });
        });

        editors.forEach(editor => {
            editor.addEventListener("paste", (e) => {
                e.preventDefault();
                const text = (e.originalEvent || e).clipboardData.getData('text/plain');
                document.execCommand("insertText", false, text);
            });

            editor.addEventListener("focus", () => {
                currentEditor = editor;
                restoreSelection();
                updateToolbarState();
            });

            editor.addEventListener("keyup", () => {
                saveSelection();
                updateToolbarState();
            });

            editor.addEventListener("mouseup", () => {
                saveSelection();
                updateToolbarState();
            });
        });
    });

    function saveSelection() {
        const sel = window.getSelection();
        if (sel.rangeCount > 0) {
            savedSelection = sel.getRangeAt(0);
        }
    }

    function restoreSelection() {
        const sel = window.getSelection();
        if (savedSelection) {
            sel.removeAllRanges();
            sel.addRange(savedSelection);
        }
    }

    function execCmd(cmd, val = null) {
        if (currentEditor) {
            currentEditor.focus();
            restoreSelection();
            document.execCommand(cmd, false, val);
            saveSelection();
            updateToolbarState();

            // Explicitly sync back to textareas when formatting toolbar layout runs
            currentEditor.nextElementSibling.value = currentEditor.innerHTML;
            currentEditor.nextElementSibling.dispatchEvent(new Event('input'));
        }
    }

    function execBlockCommand(tag) {
        if (!currentEditor) return;

        currentEditor.focus();
        restoreSelection();

        document.execCommand('formatBlock', false, tag);

        const selection = window.getSelection();
        let blockNode = selection.anchorNode;
        if (blockNode.nodeType === 3) {
            blockNode = blockNode.parentNode;
        }

        while (blockNode && blockNode !== currentEditor && blockNode.nodeName !== tag) {
            blockNode = blockNode.parentNode;
        }

        if (blockNode && blockNode.nodeName === tag) {
            blockNode.className = HEADING_CLASSES[tag];
        } else if (blockNode && blockNode.nodeName === 'P') {
            blockNode.className = HEADING_CLASSES['P'];
        }

        saveSelection();
        updateToolbarState();

        currentEditor.nextElementSibling.value = currentEditor.innerHTML;
        currentEditor.nextElementSibling.dispatchEvent(new Event('input'));
    }

    function updateToolbarState() {
        const toolbar = document.getElementById("editor-toolbar");
        let activeBlockTag = null;
        const selection = window.getSelection();

        if (selection.rangeCount > 0) {
            let node = selection.getRangeAt(0).startContainer;
            if (node.nodeType === 3) {
                node = node.parentNode;
            }
            while (node && node !== currentEditor && !['H1', 'H2', 'H3', 'P', 'UL', 'OL'].includes(node.nodeName)) {
                node = node.parentNode;
            }
            if (node && node !== currentEditor) {
                activeBlockTag = node.nodeName;
            }
        }

        toolbar.querySelectorAll(".toolbar-btn").forEach(btn => {
            const cmd = btn.dataset.cmd;
            const tag = btn.dataset.tag;
            let isActive = false;

            if (cmd) {
                isActive = document.queryCommandState(cmd);
            } else if (tag) {
                isActive = (tag === activeBlockTag);
            }

            if (isActive) {
                btn.classList.add("bg-pink-200", "border-pink-400");
                btn.classList.remove("bg-gray-100", "hover:bg-gray-200");
            } else {
                btn.classList.remove("bg-pink-200", "border-pink-400");
                btn.classList.add("bg-gray-100", "hover:bg-gray-200");
            }
        });
    }
</script>
