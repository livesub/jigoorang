// 약관동의
function CheckForm(join) {
  const chk1 = document.Join.check1.checked;
  const chk2 = document.Join.check2.checked;
  const chk3 = document.Join.check3.checked;
  // const chk4=document.Join.check4.checked;

  if (chk1 == "") {
    alert('약관에동의해 주세요');
    return false;
  }
  if (chk2 == "") {
    alert('약관에동의해 주세요');
    return false;
  }
  if (chk3 == "") {
    alert('약관에동의해 주세요');
    return false;
  }

}

function checkSelectAll() {
  // 전체 체크박스
  const checkboxes
    = document.querySelectorAll('input[name="check"]');
  // 선택된 체크박스
  const checked
    = document.querySelectorAll('input[name="check"]:checked');
  // select all 체크박스
  const selectAll
    = document.querySelector('input[name="selectall"]');

  if (checkboxes.length === checked.length) {
    selectAll.checked = true;
  } else {
    selectAll.checked = false;
  }

}

function selectAll(selectAll) {
  const checkboxes
    = document.getElementsByName('check');

  checkboxes.forEach((checkbox) => {
    checkbox.checked = selectAll.checked
  })
}

