<template>
  <div class="app-container">
    <!-- 搜索 -->
    <div class="filter-container">
      <el-input @keyup.enter.native="handleFilter" style="width: 200px;" class="filter-item" :placeholder="$t('table.title')" v-model="listQuery.title">
      </el-input>
      <el-select @change='handlerSort' style="width: 140px" class="filter-item" v-model="listQuery.sort">
        <el-option v-for="item in sortOptions" :key="item.key" :label="item.label" :value="item.key">
        </el-option>
      </el-select>
      <el-button class="filter-item" type="primary" v-waves icon="el-icon-search" @click="handleFilter">搜索</el-button>
      <el-button class="filter-item" style="margin-left: 10px;" @click="handleCreate" type="primary" icon="el-icon-edit">新增</el-button>
      <el-button class="filter-item" type="primary" :loading="downloadLoading" v-waves icon="el-icon-download" @click="handleDownload">{{$t('table.export')}}</el-button>
    </div>
    <!-- 列表 -->
    <el-table :key='tableKey' :data="list" v-loading="listLoading" border fit highlight-current-row
      style="width: 100%;min-height:1000px;">
      <el-table-column
        prop="id"
        label="ID"
        width="180">
      </el-table-column>
      <el-table-column
        prop="name"
        label="姓名"
        width="180">
      </el-table-column>
      <el-table-column
        prop="degree"
        label="学历"
        width="180">
      </el-table-column>
      <el-table-column
        prop="school"
        label="毕业院校"
        width="180">
      </el-table-column>
      <el-table-column
        prop="mobile"
        label="手机号"
        width="180">
      </el-table-column>
      <el-table-column
        prop="startTime"
        label="入职时间"
        width="180">
      </el-table-column>
      <el-table-column
        prop="grade.name"
        label="负责班级"
        width="180">
      </el-table-column>

      <el-table-column align="center" :label="$t('table.actions')" width="230" class-name="small-padding fixed-width">
        <template slot-scope="scope">
          <el-button type="primary" size="mini" @click="handleUpdate(scope.row)">{{$t('table.edit')}}</el-button>
         <!--  <el-button v-if="scope.row.status!='published'" size="mini" type="success" @click="handleModifyStatus(scope.row,'published')">{{$t('table.publish')}}
          </el-button> -->
          <!-- <el-button v-if="scope.row.status!='draft'" size="mini" @click="handleModifyStatus(scope.row,'draft')">{{$t('table.draft')}}
          </el-button> -->
          <el-button v-if="scope.row.status!='deleted'" size="mini" type="danger" @click="handleDelete(scope.row)">{{$t('table.delete')}}
          </el-button>
        </template>
      </el-table-column>
    </el-table>

    <div class="pagination-container">
      <el-pagination background @size-change="handleSizeChange" @current-change="handleCurrentChange" :current-page="listQuery.page" :page-sizes="[10,20,30, 50]" :page-size="listQuery.limit" layout="total, sizes, prev, pager, next, jumper" :total="total">
      </el-pagination>
    </div>

    <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisible">
      <el-form :rules="rules" ref="dataForm" :model="temp" label-position="left" label-width="100px" style='width: 400px; margin-left:50px;'>
        <el-form-item label="姓名" prop="name">
          <el-input v-model="temp.name"></el-input>
        </el-form-item>
        <el-form-item label="学历" prop="degree">
          <el-select v-model="temp.degree" placeholder="请选择学历">
            <el-option label="专科" value="1"></el-option>
            <el-option label="本科" value="2"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="毕业院校" prop="school">
          <el-input v-model="temp.school"></el-input>
        </el-form-item>
        <el-form-item label="手机号" prop="mobile">
          <el-input v-model="temp.mobile"></el-input>
        </el-form-item>
        <el-form-item label="入职时间" prop="startTime">
          <el-date-picker v-model="temp.startTime" type="datetime" placeholder="请选择入职时间">
          </el-date-picker>
        </el-form-item>
        <el-form-item label="班级名称" prop="grade_id">
          <el-select v-model="temp.grade_id" placeholder="请选择班级名称">
            <el-option v-for="(item,idx) in gradeList" :key="idx" :label="item.name" :value="item.id"></el-option>
          </el-select>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible = false">{{$t('table.cancel')}}</el-button>
        <el-button v-if="dialogStatus=='create'" type="primary" @click="createData">{{$t('table.confirm')}}</el-button>
        <el-button v-else type="primary" @click="updateData">{{$t('table.confirm')}}</el-button>
      </div>
    </el-dialog>

    <el-dialog title="Reading statistics" :visible.sync="dialogPvVisible">
      <el-table :data="pvData" border fit highlight-current-row style="width: 100%">
        <el-table-column prop="key" label="Channel"> </el-table-column>
        <el-table-column prop="pv" label="Pv"> </el-table-column>
      </el-table>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="dialogPvVisible = false">{{$t('table.confirm')}}</el-button>
      </span>
    </el-dialog>

  </div>
</template>

<script>
import { fetchList, fetchPv, createArticle, updateArticle, deletArticle, getGrade } from '@/api/teacher'
import waves from '@/directive/waves' // 水波纹指令
import { parseTime } from '@/utils'
import { date_format } from '@/utils/common.js'


export default {
  name: 'complexTable',
  directives: {
    waves
  },
  data() {
    var validPhone = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('请输入手机号'));
        } else if (!/^1[3|4|5|7|8][0-9]\d{8}$/.test(value)) {
          callback(new Error('请输入正确的手机号!'));
        } else {
          callback();
        }
      };
    return {
      tableKey: 0,
      list: null,
      total: null,
      listLoading: true,
      listQuery: {
        page: 1,
        limit: 10,
        importance: undefined,
        title: undefined,
        type: undefined,
        sort: 'DESC'
      },
      importanceOptions: [1, 2, 3],
      sortOptions: [{ label: '升序', key: 'ASC' }, { label: '降序', key: 'DESC' }],
      statusOptions: ['published', 'draft', 'deleted'],
      showReviewer: false,
      temp: {
        id: undefined,
        name:'',
        degree: '',
        school: '',
        timestamp: new Date(),
        startTime:'',
        mobile:'',
        grade_id:''
      },
      dialogFormVisible: false,
      dialogStatus: '',
      textMap: {
        update: '编辑',
        create: '新增'
      },
      dialogPvVisible: false,
      pvData: [],
      rules: {
        // timestamp: [{ type: 'date', required: true, message: 'timestamp is required', trigger: 'change' }],
         name: [
            { required: true,message:'请输入姓名',trigger:'change' }
          ],
        degree:[{required:true,message:'请输入学位',trigger:'change'}],
        school:[{required:true,message:'请输入毕业院校',trigger:'change'}],
        startTime:[{required:true,message:'请选择入职时间',trigger:'change'}],
        mobile:[{required:true,trigger:'change',validator:validPhone}],
        grade_id:[{required:true,message:'请选择班级名称',trigger:'change'}]
      },
      downloadLoading: false,
      gradeList:[]
    }
  },
  filters: {
    statusFilter(status) {
      const statusMap = {
        published: 'success',
        draft: 'info',
        deleted: 'danger'
      }
      return statusMap[status]
    },
    typeFilter(type) {
      return calendarTypeKeyValue[type]
    }
  },
  created() {
    this.getList();
    this.getGrade();
    // console.log(date_format(new Date().valueOf(),'yyyy-MM-dd HH:mm:ss'))
  },
  methods: {
    getList() {
      this.listLoading = true
      fetchList(this.listQuery).then(response => {
        this.list = response.data.data
        this.list.forEach((item)=>{
          item.startTime = date_format(item.hiredate*1000,'yyyy-MM-dd HH:mm:ss');
          if(item.degree == 1){
            item.degree = '专科'
          }else{
            item.degree = '本科'
          }
        })
        this.total = response.data.total
        // console.log(response)
        // Just to simulate the time of the request
        setTimeout(() => {
          this.listLoading = false
        }, 1.5 * 1000)
      })
    },
    //获取班级列表
    getGrade(){
      this.listLoading = true
      getGrade().then((res)=>{
        this.gradeList  = res.data.data;
        console.log(this.gradeList)
        setTimeout(() => {
          this.listLoading = false
        }, 1.5 * 1000)
      })
    },
    //排序
    handlerSort(){
      this.listQuery.page = 1;
      console.log(this.listQuery.sort);
      this.getList()
    },
    //搜索
    handleFilter() {
      this.listQuery.page = 1
      this.getList()
    },
    handleSizeChange(val) {
      this.listQuery.limit = val
      this.getList()
    },
    handleCurrentChange(val) {
      this.listQuery.page = val
      this.getList()
    },
    handleModifyStatus(row, status) {
      this.$message({
        message: '操作成功',
        type: 'success'
      })
      row.status = status
    },
    resetTemp() {
      this.temp = {
        id: undefined,
        name:'',
        degree: '',
        school: '',
        timestamp: new Date(),
        startTime:'',
        mobile:'',
        grade_id:''
      }
    },
    //新增
    handleCreate() {
      this.resetTemp()
      this.dialogStatus = 'create'
      this.dialogFormVisible = true
      this.$nextTick(() => {
        this.$refs['dataForm'].clearValidate()
      })
    },
  //  确认新增
    createData() {
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
          this.temp.id = parseInt(Math.random() * 100) + 1024 // mock a id
          this.temp.hiredate = new Date(this.temp.startTime).valueOf();
          if(this.temp.degree == '本科'){
            this.temp.degree = 1
          }else{
            this.temp.degree = 2
          }
          createArticle(this.temp).then((res) => {
            // this.list.unshift(this.temp)
            this.list = res.data.data;
            this.list.forEach((item)=>{
              item.startTime = date_format(item.hiredate,'yyyy-MM-dd HH:mm:ss');
              if(item.degree == 1){
                item.degree = '专科'
              }else{
                item.degree = '本科'
              }
            })
            this.dialogFormVisible = false
            this.$notify({
              title: '成功',
              message: '创建成功',
              type: 'success',
              duration: 2000
            })
          })
        }
      })
    },
    //编辑
    handleUpdate(row) {
      console.log(row)
      this.temp = Object.assign({}, row) // copy obj
      this.temp.timestamp = new Date(this.temp.timestamp)
      this.dialogStatus = 'update'
      this.dialogFormVisible = true
      this.$nextTick(() => {
        this.$refs['dataForm'].clearValidate()
      })
    },
    //编辑确认
    updateData() {
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
          const tempData = Object.assign({}, this.temp)
          tempData.timestamp = +new Date(tempData.timestamp) // change Thu Nov 30 2017 16:41:05 GMT+0800 (CST) to 1512031311464
          tempData.hiredate = new Date(tempData.startTime).valueOf();
          updateArticle(tempData).then((res) => {
            this.getList();
            for (const v of this.list) {
              if (v.id === this.temp.id) {
                const index = this.list.indexOf(v)
                this.list.splice(index, 1, this.temp)
                break
              }
            }
            this.dialogFormVisible = false
            this.$notify({
              title: '成功',
              message: '更新成功',
              type: 'success',
              duration: 2000
            })
          })
        }
      })
    },
  //删除
    handleDelete(row) {
      deletArticle({id:row.id}).then((res)=>{
        this.getList();
        this.$notify({
          title: '成功',
          message: '删除成功',
          type: 'success',
          duration: 2000
        }) 
      })
    },
    handleFetchPv(pv) {
      fetchPv(pv).then(response => {
        this.pvData = response.data.pvData
        this.dialogPvVisible = true
      })
    },
    handleDownload() {
      this.downloadLoading = true
      import('@/vendor/Export2Excel').then(excel => {
        const tHeader = ['timestamp', 'title', 'type', 'importance', 'status']
        const filterVal = ['timestamp', 'title', 'type', 'importance', 'status']
        const data = this.formatJson(filterVal, this.list)
        excel.export_json_to_excel({
          header: tHeader,
          data,
          filename: 'table-list'
        })
        this.downloadLoading = false
      })
    },
    formatJson(filterVal, jsonData) {
      return jsonData.map(v => filterVal.map(j => {
        if (j === 'timestamp') {
          return parseTime(v[j])
        } else {
          return v[j]
        }
      }))
    }
  }
}
</script>
