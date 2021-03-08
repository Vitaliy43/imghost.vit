  <div class="tab-pane {if $net == 'vk'} active {/if}" id="VK">
                <table class="table table-striped table-bordered table-hover table-condensed content_big_td">
                    <thead>
                        <tr>
                            <th colspan="6">
                                {$settings.name}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6">
                                <div class="inside_padd span9">
                                    <div class="control-group">
                                        <div class="control-label"></div>
                                        <div class="controls">
                                            <span class="frame_label">
                                                <span class="niceCheck b_n">
                                                    <input type="checkbox" name="vk[use]" value="1"{if $settings.active == 1}checked="checked"{/if} id="foncheck" />
                                                </span>
                                                {lang("Switch on integration with VKontakte?", 'social_servises')}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="protkey">{lang("Protection key", 'social_servises')}:</label>
                                        <div class="controls">
                                            <input type="text" value="{echo $settings.api_key}" name="vk[api_key]" id="api_key"/> 
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="vappnumber">{lang("Application number", 'social_servises')}:</label>
                                        <div class="controls">
                                            <input type="text" value="{echo $settings.api_id}" name="vk[api_id]" id="api_id"/> 
                                        </div>
                                    </div>
                                   
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>