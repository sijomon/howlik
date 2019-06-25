<div class="container m-t-10 m-b-10">
		<div class="row">
			<div class="col-md-12">

			
					<p>
						
					</p>
					<table class="table table-condensed table-bordered" style="m-t-10">
						<thead>
				          <tr>
				          	<th>
				          		Language
				          	</th>
				          	
				            
				              <th>ID</th>
				          

				         
				              <th>Category Name</th>
							  <th>Active</th>
							  <th>Actions</th>
				          </tr>
					    </thead>
					    <tbody>
				    		<?php $a1 ='';$b='';
							if(!empty($subcat))
							{
				                        foreach($subcat as $sub)
										{
				                         ?>
				    			<tr>
				    				<td>
				    					<?php
				                        echo $sub->name;
				                         ?>
				    				</td>

				    			
				                        <td><?php
				                        echo $sub->subcat_id;
				                         ?></td>
				                     
				                        <td><?php
				                        
				                         echo $sub->subcat;
				                         ?></td>
				                      
				                        <td><input name="active" type="checkbox" <?php if ($sub->active == 1) { ?>  checked="checked" <?php } ?> /></td>
				                      

				                   
				                    <td>
				                       
				                        <a href="<?php echo url('admin/subcategoryEdit/'.$sub->subcat_id)?>" class="btn btn-xs btn-default"><i class="fa fa-edit"></i>Edit</a>
				                     
				                      <a onclick="return confirm('Remove this subcategory ?');" href="<?php echo url('admin/subcategory_delete/'.$sub->subcat_id)?>" class="btn btn-xs btn-default" ><i class="fa fa-trash"></i> Delete</a>
				                     
				                    </td>
				                   
				    			</tr>
								
								
								<?php 
									
									if(in_array($sub->abbr,$a)){
										$b[] = $sub->abbr;
									}
									
								} }?>
						</tbody>
					</table>
					
				<br></br>
				
					<?php //echo "<pre>";print_r($lang);die;
					if(!empty($lang))
					{
						echo "Add translation to: ";
						
					
					foreach($lang as $lang1){
						if(in_array($lang1->abbr,$b)){}else{
					?>
					<a class="btn btn-xs btn-default" href="<?php echo url('admin/subcategoryEdit1/'.$lang1->abbr.'/'.$sub->subcat_id) ?>"><i class="fa fa-plus"></i> <?php echo $lang1->langname ?></a>
					<?php
						}}}
					?>
						
					
			</div>
		</div>
	</div>
