		<div style="border-color: #B4BBCD #B4BBCD #CCCCCC;border-style: solid; border-width: 1px;padding: 5px;">
			<div style="padding: 5px;"><b>Name:</b>&nbsp;&nbsp;<input type="text" style="width:350px" name="node_name" value="<?php echo $this->node_name?>"></div>
			<div style="padding: 5px;"><b>Status:</b>&nbsp;&nbsp;<input type="radio" name="status" value="draft" <?php echo ($this->status == 'draft'? "checked" : '') ?> /> Draft &nbsp;&nbsp;<input type="radio" name="status" value="active" <?php echo ($this->status == 'active'? "checked" : '') ?>> Active </div>
			<div style="padding:10px 0 0 5px">
			<table cellspacing="0" cellpadding="0" width="98%">
            	<tbody><tr>
            		<td style="border: 1px solid rgb(128, 128, 128);">
            			<div style="padding: 5px;">
							<table width="600px;" cellspacing="0" cellpadding="0" border="0">
								<tbody><tr>
									<td align="left">
										<img src="/images/en_f.png"> <b>English</b>
									</td>
								</tr>
							</tbody></table>
						</div>
            		</td>
            	</tr>
				<tr>
					<td style="border-left: 1px solid rgb(128, 128, 128); border-right: 1px solid rgb(128, 128, 128); border-bottom: 1px solid rgb(128, 128, 128);">
						<div style="padding: 5px;">
						<b>Content</b>
						<textarea id="body_en" name="body_en" style="width:610px;height:150px"><?php echo $this->body_en?></textarea>
						</div>
                    </td>
            	</tr>
			</tbody></table>
			</div>
			<div style="padding:15px 0 0 5px">
			<table cellspacing="0" cellpadding="0" width="98%">
            	<tbody><tr>
            		<td style="border: 1px solid rgb(128, 128, 128);">
            			<div style="padding: 5px;">
							<table width="600px;" cellspacing="0" cellpadding="0" border="0">
								<tbody><tr>
									<td align="left">
										<img src="/images/kr_f.png"> <b>Korean</b>
									</td>
								</tr>
							</tbody></table>
						</div>
            		</td>
            	</tr>
				<tr>
					<td style="border-left: 1px solid rgb(128, 128, 128); border-right: 1px solid rgb(128, 128, 128); border-bottom: 1px solid rgb(128, 128, 128);">
						<div style="padding: 5px;">
						<b>Content</b>
						<textarea id="body_kr" name="body_kr" style="width:610px;height:150px"><?php echo $this->body_kr?></textarea>
						</div>
                    </td>
            	</tr>
			</tbody></table>
			</div>
			<!--  
			<div style="padding:15px 0 0 5px">
			<table cellspacing="0" cellpadding="0" width="98%">
            	<tbody><tr>
            		<td style="border: 1px solid rgb(128, 128, 128);">
            			<div style="padding: 5px;">
							<table width="600px;" cellspacing="0" cellpadding="0" border="0">
								<tbody><tr>
									<td align="left">
										<img src="/images/vi_f.png"> <b>Vietnamese</b>
									</td>
								</tr>
							</tbody></table>
						</div>
            		</td>
            	</tr>
				<tr>
					<td style="border-left: 1px solid rgb(128, 128, 128); border-right: 1px solid rgb(128, 128, 128); border-bottom: 1px solid rgb(128, 128, 128);">
						<div style="padding: 5px;">
						<b>Content</b>
						<textarea id="body_vi" name="body_vi" style="width:610px;height:150px"><?php echo $this->body_vi?></textarea>
						</div>
                    </td>
            	</tr>
			</tbody></table>
			</div>
			-->
			<div style="padding:15px 5px 5px 0;float:right">
			 <input type="button" value="Save" onclick="submitForm()"/> <input type="button" value="Cancel" onclick="kfm.util.gotoURL('/node/?type=<?php echo $this->node_type; ?>')"/>
			</div>
			<br style="clear:both"/>
		</div>