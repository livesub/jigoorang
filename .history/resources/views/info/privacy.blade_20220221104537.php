@extends('layouts.head')

@section('content')




    <!-- 서브 컨테이너 시작 -->
    <div class="sub-container">

        <!-- 위치 시작 -->
        <div class="location">
            <ul>
                <li><a href="/">홈</a></li>
                <li><a href="{{ route('privacy') }}">개인정보 처리 방침</a></li>
            </ul>
        </div>
        <!-- 위치 끝 -->

        <!-- 타이틀 시작 -->
        <div class="title_area_01 mb-50">
            <h2>개인정보 처리 방침</h2>
        </div>
        <!-- 타이틀 끝 -->

        <!-- 개인정보 시작  -->
            <div class="terms">

                <!-- 개인정보 컨텐츠 시작 -->
                <div class="terms_wrap">
                    <div class="terms_text">

                    <p>< 지구랭 >('jigoorang.com'이하 '지구랭')은 「개인정보 보호법」 제30조에 따라 정보주체의 개인정보를 보호하고 이와 관련한 고충을 신속하고 원활하게 처리할 수 있도록 하기 위하여 다음과 같이 개인정보 처리방침을 수립·공개합니다.<br>
                    </p>
                    <br><br>

                    <h4 class="mb-20">제1조 개인정보의 수집항목 및 이용 목적</h4>

                    <p>
                        지구랭은 다음의 목적을 위하여 개인정보를 처리합니다. 처리하고 있는 개인정보는<br>
                        다음의 목적 이외의 용도로는 이용되지 않으며 이용 목적이 변경되는 경우에는 「개인정보 보호법」 제18조에 따라 별도의 동의를 받는 등 필요한 조치를 이행할 예정입니다
                        <br>
                        수집하는 개인정보 항목과 수집 및 이용목적은 다음과 같습니다.<br>

                        <br>
                        1. 일반 회원 정보
                        - 수집 시기 : 가입시
                        - 수집 항목 : 이름, 이메일 주소, 비밀번호, 핸드폰번호, 생년월일, 성별
                        - 이용 목적: 회원 가입의사 확인, 회원제 서비스 제공에 따른 본인 식별·인증, 회원자격 유지·관리, 서비스 부정이용 방지, 각종 고지·통지, 고충처리, 새로운 서비스 및 신상품이나 이벤트 정보 등의 안내
                        <br><br>
                        2. 제품 평가단 정보
                        - 수집 시기 : 제품 평가단 신청시
                        - 수집 항목 : ① 신청자의 이름, 핸드폰 번호, 이메일 주소
                        ② 배송 수령인의 이름, 핸드폰 번호, 주소
                        - 이용목적: 평가단 응모접수 관리, 물품 발송 및 수령 확인, 평가단 진행을 위한 고지 및 문의 응대, (필요시)제세공과금 납부관련 안내, 평가 리뷰 작성시 선정된 평가단 식별·인증
                        <br><br>
                        3. 주문정보
                        - 수집 시기 : 주문시
                        - 수집 항목 : ① 주문자의 정보(이름, 이메일 주소, 비밀번호, 핸드폰번호)
                        ②수취자의 정보(이름, 주소, 휴대폰 번호)  ③결제 승인정보
                        - 이용목적: 주문 상품의 결제 및 배송

                    </p>

                    <br>

                    <h4 class="mb-20">제2조 개인정보의 처리 및 보유 기간</h4>

                    <p>
                        ① 이용자가 쇼핑몰 회원으로서 지구랭에서 제공하는 서비스를 이용하는 동안 지구랭은 이용자들의 개인정보를 계속적으로 보유하며 서비스 제공 등을 위해 이용합니다.<br>
                        고객의 개인정보는 회원탈퇴 등 수집목적 또는 제공받은 목적이 달성되면 파기하는 것을 원칙으로 합니다. <br>
                        단, 『전자상거래 등에서의 소비자보호에 관한 법률』 등 관련법령의 규정에 의하여 다음과 같이 거래 관련 권리 의무 관계의 확인 등을 일정기간 보유하여야 할 필요가 있을 경우에는 그 기간동안 보유합니다.
                        <br><br>
                        가. 『전자상거래 등에서의 소바자보호에 관한 법률』 제6조
                        - 계약 또는 청약 철회 등에 관한 기록: 5년
                        - 대금결제 및 재화 등의 공급에 관한 기록: 5년
                        - 소비자의 불만 또는 분쟁처리에 관한 기록: 3년
                        <br><br>
                        나. 『통신비밀보호법』 제15조의 2
                        - 방문(로그)에 관한 기록: 1년
                        <br>
                        다. 기타 관련 법령 등
                    </p>

                    <br>

                    <h4 class="mb-20">제3조(개인정보의 제3자 제공)</h4>

                    <p>
                        ①지구랭은 고객의 개인정보를 “제1조 개인정보의 수집항목 및 이용목적”에서 고지한 범위를 넘어 이용하거나 타인 또는 타기업, 기관에 제공하지 않습니다. <br><br>
                        다만 정보주체의 동의, 법률의 특별한 규정 등 「개인정보 보호법」 제17조 및 제18조에 해당하는 경우에만 개인정보를 제3자에게 제공합니다.<br><br>
                        ②제품 구매 후기 및 제품 평가단의 사용 평가 • 후기 등은 통계작성 및 시장조사 등을 위하여 협력사(판매사)에 특정 개인을 식별할 수 없는 형태로 제공할 수 있습니다.
                    </p>

                    <br>

                    <h4 class="mb-20">제4조(개인정보처리 위탁)</h4>

                    <p>
                        ① 지구랭은 원활한 개인정보 업무처리를 위하여 다음과 같이 개인정보 처리업무를 위탁하고 있습니다.<br><br>

                        - 주문 상품의 배송:  우체국 <br>
                        - 결제 및 에스크로 서비스:  ㈜아임포트<br>
                        - 평가단 운영을 위한 물품 배송, 수령 확인 및 평가단 관련 안내와 응대 등 : 투비위어드<br>
                        - 본인확인, 아이핀 서비스:  ㈜알리는사람들<br><br>

                        ② 지구랭은 위탁계약 체결시 「개인정보 보호법」 제26조에 따라 위탁업무 수행목적 외 개인정보 처리금지, 기술적·관리적 보호조치, 재위탁 제한, 수탁자에 대한 관리·감독, 손해배상 등 책임에 관한 사항을 계약서 등 문서에 명시하고, 수탁자가 개인정보를 안전하게 처리하는지를 감독하고 있습니다.
                        <br><br>
                        ③ 위탁업무의 내용이나 수탁자가 변경될 경우에는 지체없이 본 개인정보 처리방침을 통하여 공개하도록 하겠습니다.

                    </p>

                    <br>

                    <h4 class="mb-20">제5조(정보주체와 법정대리인의 권리·의무 및 그 행사방법)</h4>

                    <p>
                        ① 정보주체는 지구랭에 대해 언제든지 개인정보 열람·정정·삭제·처리정지 요구 등의 권리를 행사할 수 있습니다.<br><br>

                        ② 제1항에 따른 권리 행사는 지구랭에 대해 「개인정보 보호법」 시행령 제41조 제1항에 따라 서면, 전자우편, 모사전송(FAX) 등을 통하여 하실 수 있으며 지구랭은 이에 대해 지체 없이 조치하겠습니다.<br><br>

                        ③ 제1항에 따른 권리 행사는 정보주체의 법정대리인이나 위임을 받은 자 등 대리인을 통하여 하실 수 있습니다. 이 경우 “개인정보 처리 방법에 관한 고시(제2020-7호)” 별지 제11호 서식에 따른 위임장을 제출하셔야 합니다.<br><br>

                        ④ 개인정보 열람 및 처리정지 요구는 「개인정보 보호법」 제35조 제4항, 제37조 제2항에 의하여 정보주체의 권리가 제한될 수 있습니다.<br><br>

                        ⑤ 개인정보의 정정 및 삭제 요구는 다른 법령에서 그 개인정보가 수집 대상으로 명시되어 있는 경우에는 그 삭제를 요구할 수 없습니다.<br><br>

                        ⑥ 지구랭은 정보주체 권리에 따른 열람의 요구, 정정·삭제의 요구, 처리정지의 요구 시 열람 등 요구를 한 자가 본인이거나 정당한 대리인인지를 확인합니다.
                    </p>

                    <br>

                    <h4 class="mb-20">제6조(개인정보의 파기)</h4>

                    <p>

                        ① 지구랭은 개인정보 보유기간의 경과, 처리목적 달성 등 개인정보가 불필요하게 되었을 때에는 지체없이 해당 개인정보를 파기합니다.<br><br>

                        ② 정보주체로부터 동의 받은 개인정보 보유기간이 경과하거나 처리목적이 달성되었음에도 불구하고 다른 법령에 따라 개인정보를 계속 보존하여야 하는 경우에는, 해당 개인정보를 별도의 데이터베이스(DB)로 옮기거나 보관장소를 달리하여 보존합니다.<br><br>

                        ③ 개인정보 파기의 절차 및 방법은 다음과 같습니다.<br><br>
                        1. 파기절차
                        지구랭은 파기 사유가 발생한 개인정보를 선정하고, 지구랭의 개인정보 보호책임자의 승인을 받아 개인정보를 파기합니다.<br><br>

                        2. 파기방법
                        전자적 파일 형태의 정보는 기록을 재생할 수 없는 기술적 방법을 사용합니다. 종이에 출력된 개인정보는 분쇄기로 분쇄하거나 소각을 통하여 파기합니다.

                    </p>

                    <br>

                    <h4 class="mb-20">제7조(개인정보의 안전성 확보 조치)</h4>

                    <p>
                        지구랭은 개인정보의 안전성 확보를 위해 다음과 같은 조치를 취하고 있습니다.  <br><br>

                        1. 해킹 등에 대비한 기술적 대책
                        지구랭은 해킹이나 컴퓨터 바이러스 등에 의한 개인정보 유출 및 훼손을 막기 위하여 보안프로그램을 설치하고 주기적인 갱신·점검을 하며 외부로부터 접근이 통제된 구역에 시스템을 설치하고 기술적/물리적으로 감시 및 차단하고 있습니다.
                        <br><br>
                        2. 개인정보의 암호화
                        이용자의 개인정보는 비밀번호는 암호화되어 저장 및 관리되고 있어, 본인만이 알 수 있으며 중요한 데이터는 파일 및 전송 데이터를 암호화하거나 파일 잠금 기능을 사용하는 등의 별도 보안기능을 사용하고 있습니다.
                    </p>

                    <br>

                   <h4 class="mb-20">제8조(14세 미만 아동의 개인정보보호)</h4>

                    <p>
                        지구랭은 법정대리인의 동의가 필요한 만 14세 미만 아동의 회원가입은 받고 있지 않습니다.
                        명의도용이나 시스템 악용 등으로 만 14세 미만의 아동이 사이트에 가입하거나 개인정보를 제공하게 될 경우 법정대리인이 모든 권리를 행사할 수 있습니다
                    </p>

                    <br>

                    <h4 class="mb-20">제9조(개인정보 자동 수집 장치의 설치•운영 및 거부에 관한 사항)</h4>

                    <p>
                        ① 지구랭은 이용자에게 개별적인 맞춤서비스를 제공하기 위해 이용정보를 저장하고 수시로 불러오는 ‘쿠키(cookie)’를 사용합니다.<br><br>
                        ② 쿠키는 웹사이트를 운영하는데 이용되는 서버(http)가 이용자의 컴퓨터 브라우저에게 보내는 소량의 정보이며 이용자들의 PC 컴퓨터내의 하드디스크에 저장되기도 합니다.<br><br>
                        가. 쿠키의 사용 목적 : 이용자가 방문한 각 서비스와 웹 사이트들에 대한 방문 및 이용형태, 인기 검색어, 보안접속 여부, 등을 파악하여 이용자에게 최적화된 정보 제공을 위해 사용됩니다.<br><br>
                        나. 쿠키의 설치•운영 및 거부 : 웹브라우저 상단의 도구>인터넷 옵션>개인정보 메뉴의 옵션 설정을 통해 쿠키 저장을 거부 할 수 있습니다.<br><br>
                        다. 쿠키 저장을 거부할 경우 맞춤형 서비스 이용에 어려움이 발생할 수 있습니다.
                    </p>

                    <br>

                    <h4 class="mb-20">제10조 (개인정보 보호책임자)</h4>
                    <p>
                        ① 지구랭 은(는) 개인정보 처리에 관한 업무를 총괄해서 책임지고, 개인정보 처리와 관련한 정보주체의 불만처리 및 피해구제 등을 위하여 아래와 같이 개인정보 보호책임자를 지정하고 있습니다.<br><br>

                        ▶ 개인정보 보호책임자<br>
                        담당자 : 지구랭<br>
                        연락처 : jigoorang_hehe@naver.com<br><br>

                        ② 정보 주체께서는 지구랭의 서비스(또는 사업)을 이용하시면서 발생한 모든 개인정보 보호 관련 문의, 불만처리, 피해구제 등에 관한 사항을 개인정보 보호책임자 및 담당부서로 문의하실 수 있습니다.<br>
                         지구랭은 정보주체의 문의에 대해 지체 없이 답변 및 처리해드릴 것입니다.
                    </p>

                    <br>

                    <h4 class="mb-20">제11조(개인정보 열람청구)</h4>
                     <p> 정보주체는 ｢개인정보 보호법｣ 제35조에 따른 개인정보의 열람 청구를 아래의 담당자에 할 수 있습니다. 지구랭은 정보주체의 개인정보 열람청구가 신속하게 처리되도록 노력하겠습니다.<br><br>

                        ▶ 개인정보 열람청구 접수·처리 담당자<br>
                        담당자 : 지구랭<br>
                        연락처 : jigoorang_hehe@naver.com
                    </p>

                    <br>

                    <h4 class="mb-20">제12조(권익침해 구제방법)</h4>

                    <p>
                        정보주체는 개인정보침해로 인한 구제를 받기 위하여 개인정보분쟁조정위원회, 한국인터넷진흥원 개인정보침해신고센터 등에 분쟁해결이나 상담 등을 신청할 수 있습니다.<br>
                         이 밖에 기타 개인정보침해의 신고, 상담에 대하여는 아래의 기관에 문의하시기 바랍니다.<br><br>

                        1. 개인정보분쟁조정위원회 : (국번없이) 1833-6972 (www.kopico.go.kr)<br>
                        2. 개인정보침해신고센터 : (국번없이) 118 (privacy.kisa.or.kr)<br>
                        3. 대검찰청 : (국번없이) 1301 (www.spo.go.kr)<br>
                        4. 경찰청 : (국번없이) 182 (ecrm.cyber.go.kr)<br><br>

                        「개인정보보호법」제35조(개인정보의 열람), 제36조(개인정보의 정정·삭제), 제37조(개인정보의 처리정지 등)의 규정에 의한 요구에 대 하여 공공기관의 장이 행한 처분 또는 부작위로 인하여 권리 또는 이익의 침해를 받은 자는 행정심판법이 정하는 바에 따라 행정심판을 청구할 수 있습니다.<br><br>

                        ※ 행정심판에 대해 자세한 사항은 중앙행정심판위원회(www.simpan.go.kr) 홈페이지를 참고하시기 바랍니다.<br>
                    </p>

                    <br>

                    <h4 class="mb-20">제13조(개인정보 처리방침 변경)</h4>

                    <p>
                        이 개인정보처리방침은 <사이트 개설일>부터 적용됩니다
                    </p>

                    <br>
                    </div>


                </div>
                <!-- 개인정보 컨텐츠 끝 -->
            </div>
            <!-- 개인정보 끝  -->



    </div>
    <!-- 서브 컨테이너 끝 -->




@endsection