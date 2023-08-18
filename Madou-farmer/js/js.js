    $(document).ready(function () {
        const myTable = $('#myTable');
        const myTbody = $('#myTbody');

        const itemBtn = $('.itemBtn')
        const stockNameAll = $('.stockName');
        const numInput = $('.numInput');
        const freightInput = $('.freightInput');
        const psInput = $('.psInput');
        const myTotal = $('.totalInput');

        const checkBtn = $('#checkBtn');
        const containerItems = $('#container-items');
        const delBtnAll = $('.delBtnAll');

        const exDiv = $('#exDiv');

        let url = 'https://soa.tainan.gov.tw/Api/Service/Get/248ce660-a53e-4a53-8d51-7842f4b5c2d0';
        let content = '';

        // 使用Ajax方法取得資料
        $.ajax({
            type: "get",
            url: url,
            // data: "data",
            dataType: "json",
            success: function (res) {
                // console.log(res);

                // 將res的下一層data欄位先用['data']包進來，以簡化之後的程式碼
                let data = res['data'];
                // console.log('data', data);
                // console.log('data[data]', data['data']);
                // console.log('data["data"][0]["Seq"]', data["data"][0]["Seq"]);
                // console.log('data["data"][0]["農產品"]', data["data"][0]["農產品"]);
                // console.log('data["data"][0]["生產區"]', data["data"][0]["生產區"]);
                // console.log('data["data"][0]["生產期"]', data["data"][0]["生產期"]);

                for (let i = 0; i < data.length; i++) {
                    content = content +
                        `   <tr>
                                <td>${data[i]["Seq"]}</td>
                                <td>${data[i]["農產品"]}</td>
                                <td>${data[i]["生產區"]}</td>
                                <td>${data[i]["生產期"]}</td>
                            </tr>                         
                        `;
                }
                // console.log('content', content);

                myTbody.html(content);
                myTable.DataTable();
            }
        });


        let i = 0; //click 第幾個

        // 刪除
        delBtnAll.click(function () {
            // var nickname = prompt('請輸入你的手機號碼','O9XX-XXX-XXX');
            if (!confirm("確定要取消訂購嗎？")) {
                return false;
            }

            // 刪除點下 刪除這一'行'
            console.log('delBtn ok');
            console.log('this', this);

            // 看有幾行
            let getLength = $('.item-row').length;
            console.log('getLength', getLength);
            // 超過一行才可以刪除
            if (getLength <= 1) {
                alert('不可取消，確定結帳至少需保留一項產品');
                return false;
            }

            let nowDelBtn = $(this);
            // 去看一下html 就可以知道要幾次parent 之後console.log
            let nowRow = nowDelBtn.parent().parent().parent().parent();
            // console.log('nowDelBtn', nowDelBtn);
            // console.log('nowRow', nowRow);
            nowRow.remove();
        });

        // 選擇品項
        itemBtn.click(function () {
            // let getRowStockName = $('.item-row').first().find('.stockName').val();
            let getRowStockName = $('.item-row').first().find('.stockName').val();
            // console.log('getRowStockName', getRowStockName);
            // console.log('getRowStockName.length', getRowStockName.length);

            // getRowStockName.length == 0 代表商品沒有文字 取代
            // 有文字就執行clone

            if (getRowStockName.length > 0) {
                // 抓第一行clone                
                $('.item-row').first().clone(true).appendTo('#container-items');
            }
            // 抓最後一行 清洗value
            let lastRow = $('.item-row').last();
            // lastRow.find('input').val('');

            let stockName = $(this).attr('data-stock-name');
            console.log('stockName', stockName);
            let dataPrice = $(this).attr('data-price');
            console.log('dataPrice', dataPrice);

            lastRow.find('.stockName').val(stockName);
            lastRow.find('.numInput').val('1');
            lastRow.find('.freightInput').val('免運');
            // lastRow.find('.psInput').val('');
            lastRow.find('.psInput').val(dataPrice);
        });

        // 確定送出
        checkBtn.click(function () {
            // 點擊checkBtn後，先將exDiv購買明細資料清空
            i = 0;
            exDiv.html("");

            // value
            // console.log('stockNameAll first value', stockNameAll.first().val());
            // value.length
            // console.log('stockNameAll first value', stockNameAll.first().val().length);
            if (stockNameAll.first().val().length < 1) {
                alert('請選擇商品');
                return false;
            }

            // 下列程式碼只能存取網頁載入的第一個商品名稱，所以捨棄不用
            // $.each(stockNameAll, function (key, value) {
            //     console.log('key', key);
            //     console.log('value', value);
            // })

            let newStockNameAll = $('.stockName');
            $.each(newStockNameAll, function (key, value) {
                console.log('newkey', key);
                console.log('newvalue', $(value));


                // 1.使用parent()逐一向上找到.item-row
                let closeRow = $(value).parent().parent().parent();
                console.log('closeRow', closeRow);

                // 2.接下來使用find()找到每個input欄位 
                // let name = stockNameAll.val();
                // let num = numInput.val();
                // let freight = freightInput.val();
                // let ps = psInput.val();
                i++;
                let name = closeRow.find('.stockName').val();
                let num = closeRow.find('.numInput').val();
                let freight = closeRow.find('.freightInput').val();
                let ps = num * closeRow.find('.psInput').val();;
                // console.log('freight',freight);

                let content = `<p class="text-primary">第${i}項 產品 ${name} ${num}台斤 ${ps}元 (運費${freight})</p>`;
                exDiv.append(content);
            })
        });

        //     function getSum() {
        //     let sum = 0;
        //     $.each(myTotal, function (indexInArray, valueOfElement) {
        //         console.log('indexInArray', indexInArray);
        //         console.log('valueOfElement', valueOfElement);
        //         let totalVaule = Number($(valueOfElement).val());
        //         sum = sum + totalVaule;
        //         console.log('sum', sum);
        //     });
        //     myResult.text(sum);
        //     modalResult.text(sum);

        //     bonus.hide();
        //     if (sum > 1000) {
        //         let bonusValue = sum * 0.8;
        //         bonus.text(`恭喜您 超過1000 獲得 優惠八折 => ${bonusValue}`);
        //         // 顯示bonus
        //         bonus.show();
        //     }
        // }

        // 不能一開始就呼叫getSum()，要等myNum的change事件開始後再呼叫
        // getSum();

        //JQ Object
        // console.log('$(this)', $(this));
        numInput.change(function () {
            // $(this)表示滑鼠點擊到的數量.menu-num Class
            console.log('this', $(this));
            let numValue = $(this).val();
            console.log('numValue', numValue);

            // console.log('parent.parent.parent.find-price', $(this).parent().parent().parent().find('.menu-price'));
            // console.log('parent.parent.parent.find-total', $(this).parent().parent().parent().find('.menu-total'));
            let prices = $(this).parent().parent().parent().find('.psInput');
            let totals = $(this).parent().parent().parent().find('.totalInput');
            // console.log('prices', prices);
            // console.log('totalValue', totalValue);

            sum = Number(prices.val()) * Number($(this).val());
            // console.log('sum', sum);
            totals.val(sum);

            // console.log('myTotal.val()', myTotal.val());

            // getSum();
        })
    });
