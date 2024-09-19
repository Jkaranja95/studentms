<?php
	/**
	 * 
	 */
	class Alert{
		
		public static function create($type,$title="",$message){
			return "<div class='alert alert-".$type."'>
			<button class='close' data-dismiss='alert'>&times;</button>
			<strong>".$title."   "."</strong>".$message."
			</div>
			";
		}
		public static function create_popup($type,$title="",$message){

			return '<div class="modal fade modal-'.$type.' " id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
			<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title">'.$title.'</h4>
			</div>
			<div class="modal-body">
			'.$message.'
			</div>
			<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Continue</button>
			</div>
			</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->';
		}

		public static function create_two_btn_popup($id,$header_class,$title="",$message,$pstv_message,$neg_message,$pstv_link,$neg_link){

			return '<div class="modal fade alert-modal" id="'.$id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header '.$header_class.'">
                <h5 class="modal-title" id="exampleModalLabel">'.$title.'</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
               '.$message.'
              </div>
              <div class="modal-footer">
                <a href="'.$neg_link.'" class="btn btn-primary">'.$neg_message.'</a>
                <a href="'.$pstv_link.'" class="btn btn-success">'.$pstv_message.'</a>
              </div>
            </div>
          </div>
        </div>';
		}

	}
	?>