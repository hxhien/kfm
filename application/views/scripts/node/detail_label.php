		<div style="border-color: #B4BBCD #B4BBCD #CCCCCC;border-style: solid; border-width: 1px;padding: 5px;">
			<div style="padding: 5px;"><b>Name:</b>&nbsp;&nbsp;<input type="text" style="width:350px" name="node_name" value="<?php echo $this->node_name?>"></div>
			<input type="hidden" name="status" value="<?php echo ($this->status);?>"/>
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
						<div style="padding: 5px;"><b>Text:</b>&nbsp;&nbsp;<input type="text" style="width:80%" name="title_en" value="<?php echo $this->title_en?>"></div>
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
						<div style="padding: 5px;"><b>Text:</b>&nbsp;&nbsp;<input type="text" style="width:80%" name="title_kr" value="<?php echo $this->title_kr?>"></div>
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
						<div style="padding: 5px;"><b>Text:</b>&nbsp;&nbsp;<input type="text" style="width:80%" name="title_vi" value="<?php echo $this->title_vi?>"></div>
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