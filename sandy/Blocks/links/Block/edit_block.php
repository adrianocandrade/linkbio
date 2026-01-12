<?php
$heading = ao($block, 'name');
$content = ao($block->blocks, 'content');
?>

<script>
    function links_data_<?= $block->id ?>() {

        return {
            block_id: "<?= $block->id ?>",
            items: <?= (new \YettiBlocks)->fetch_blocks_sections($block->id)->toJson() ?>,
            item_edit_popup_show: false,


            create_block() {
                var data = {
                    block_id: this.block_id,
                };


                axios.post("<?= route('sandy-blocks-links-create') ?>", data).then(response => {
                    this.items = JSON.parse(response.data.response);
                });
            },

            delete_section(item_id) {
                var data = {
                    section_id: item_id,
                };


                axios.post("<?= route('sandy-blocks-links-section-delete') ?>", data).then(response => {

                    if (response.data) {
                        var items = Alpine.raw(this.items);
                        var new_items = [];
                        items.forEach(function (s, i) {
                            if (s.id !== item_id) {
                                new_items.push(s);
                            }
                        });
                        this.items = new_items;
                    }
                });
            },

            init() {
                Sortable.create(this.$refs.sortable_body, {
                  animation: 150,
                  sort: true,
                  scroll: true,
                  scrollSensitivity: 100,
                  delay: 150,
                  delayOnTouchOnly: true,
                  group: false,
                  //handle: '.handle',
                  swapThreshold: 5,
                  filter: ".disabled",
                  preventOnFilter: true,
                  containment: "parent",
                  onUpdate: (event) => {
                    var items = Alpine.raw(this.items)
                    var droppedAtItem = items.splice(event.oldIndex, 1)[0];
                    items.splice(event.newIndex, 0, droppedAtItem);

                    let data = [];
                    
                    items.forEach( function(s, i) {
                        let push = {
                            id: s.id,
                            position: i
                        };

                        data.push(push);
                    });



                    var send = {
                        'type': 'sort',
                        items: data,
                    };
                    
                    axios.post("<?= route('sandy-blocks-links-sort-item', $block->id) ?>", send);
                  },
                  onEnd: (event) => {
                  },
              });
            },

            edit_item($item) {
                this.item_edit_popup_show = true;

                this.$nextTick(() => {
                    var popup = this.$refs.item_popup;
                    //popup.classList.add("active");

                    popup.querySelector('[name="name"]').value = $item.content.name;
                    popup.querySelector('[name="link"]').value = $item.content.link;
                    popup.querySelector('[name="section_id"]').value = $item.id;
                    
                    var tooltip = popup.querySelector('.yetti-popup-body');
                    var button = document.querySelector('[class*="yetti-links-v2"][data-id="'+ $item.id +'"]');
                    Popper.createPopper(button, tooltip, {
                        placement: 'bottom',
                    });

                });
            },

            edit_item_post(){
                var $this = this;
                var popup = this.$refs.item_popup;
                var form = popup.querySelector('form');
                var data = Object.fromEntries(new FormData(form).entries());
                axios.post("<?= route('sandy-blocks-links-edit-section') ?>", data).then(response => {
                    if(response.data){
                        var items = Alpine.raw($this.items);
                        var new_items = [];
                        items.forEach(function(s, i) {
                            if (s.id === response.data.id) {
                                $this.items[i].content = response.data.content;
                            }
                        });

                        form.querySelector('button').removeAttribute('disabled');
                        this.item_edit_popup_show = false;
                    }
                });
            }
        }
    }

</script>

<div x-data="links_data_<?= $block->id ?>">
    <div class="yetti-links-wrapper" x-ref="sortable_body">


        <template x-for="item in items">
            <div class="yetti-links-v2 transition-none sortable-item" :data-id="item.id">
                <div class="yetti-links-v2-inner is-edit">
                    <span x-text="item.content.name"></span>
                    <div class="flex items-center">

                        <p class="drag mr-5 handle cursor-pointer">
                            <i class="sni sni-move"></i>
                        </p>
                        <a x-on:click="edit_item(item)" class="ml-auto mr-5">
                            <i class="sni sni-pen"></i>
                        </a>
                        <button x-on:click="delete_section(item.id)">
                            <i class="sni sni-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </div>
        <template x-if="item_edit_popup_show">
            <div class="yetti-popup active" x-ref="item_popup">
                <button class="button-square-stroke button-small yetti-popup-head">
                    <svg class="icon icon-filter">
                        <use xlink:href="#icon-filter"></use>
                    </svg>
                </button>

                <div class="yetti-popup-body">
                    <div class="flex items-center mb-5">
                        <div class="text-lg font-bold mr-auto"><?= __('EDIT LINK') ?></div>
                        <button class="yetti-popup-close flex items-center justify-center" x-on:click="item_edit_popup_show = false">
                            <?= svg_i('close-1', 'icon') ?>
                        </button>
                    </div>


                    <form class="m-0" @submit.prevent="edit_item_post()">
                        <input type="hidden" name="section_id">
                        <div class="form-input">
                            <label><?= __('Name') ?></label>
                            <input type="text" name="name">
                        </div>
                        <div class="form-input mt-5">
                            <label><?= __('Link') ?></label>
                            <input type="text" name="link">
                        </div>

                        <button class="sandy-expandable-btn mt-5"><span><?= __('Save') ?></span></button>
                    </form>
                </div>
                <div class="yetti-popup-overlay" x-on:click="item_edit_popup_show = false"></div>
            </div>
    </template>
    <div class="add-new-link my-5 sm">
        <button type="button" class="el-btn m-0" x-on:click="create_block()"><i class="sni sni-plus"></i></button>
    </div>
</div>
